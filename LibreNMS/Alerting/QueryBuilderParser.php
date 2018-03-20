<?php
/**
 * QueryBuilderParser.php
 *
 * -Description-
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2018 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Alerting;

use LibreNMS\Config;
use LibreNMS\DB\Schema;

class QueryBuilderParser implements \JsonSerializable
{
    private static $legacy_operators = [
        '=' => 'equal',
        '!=' => 'not_equal',
        '~' => 'regex',
        '!~' => 'not_regex',
        '<' => 'less',
        '>' => 'greater',
        '<=' => 'less_or_equal',
        '>=' => 'greater_or_equal',
    ];
    private static $operators = [
        'equal' => "=",
        'not_equal' => "!=",
        'less' => "<",
        'less_or_equal' => "<=",
        'greater' => ">",
        'greater_or_equal' => ">=",
        'begins_with' => "LIKE (\"%?\")",
        'not_begins_with' => "NOT LIKE (\"%?\")",
        'contains' => "LIKE (\"%?%\")",
        'not_contains' => "NOT LIKE (\"%?%\")",
        'ends_with' => "LIKE (\"?%\")",
        'not_ends_with' => "NOT LIKE (\"?%\")",
        'is_empty' => "=",  // value will be empty
        'is_not_empty' => "!=", // value will be empty
        'is_null' => "IS NULL",
        'is_not_null' => "IS NOT NULL",
        'regex' => 'REGEXP',
        'not_regex' => 'NOT REGEXP',
    ];

    private $builder;
    private $schema;

    private function __construct(array $builder)
    {
        $this->builder = $builder;
        $this->schema = new Schema();
    }

    /**
     * Get all tables used by this rule
     *
     * @return array
     */
    public function getTables()
    {
        if (!isset($this->tables)) {
            $this->tables = $this->findTablesRecursive($this->builder);
        }

        return $this->tables;
    }

    /**
     * Recursively find tables (including expanding macros) in the given rules
     *
     * @param array $rules
     * @return array List of tables found in rules
     */
    private function findTablesRecursive($rules)
    {
        $tables = [];

        foreach ($rules['rules'] as $rule) {
            if (array_key_exists('rules', $rule)) {
                $tables = array_merge($this->findTablesRecursive($rule), $tables);
            } elseif (str_contains($rule['field'], '.')) {
                list($table, $column) = explode('.', $rule['field']);

                if ($table == 'macros') {
                    $tables = array_merge($this->expandMacro($rule['field'], true), $tables);
                } else {
                    $tables[] = $table;
                }
            }
        }

        // resolve glue tables (remove duplicates)
        foreach (array_keys(array_flip($tables)) as $table) {
            $rp = $this->schema->findRelationshipPath($table);
            if ($rp) {
                $tables = array_merge($rp, $tables);
            }
        }

        // remove duplicates
        return array_keys(array_flip($tables));
    }

    /**
     * Initialize this from json generated by jQuery QueryBuilder
     *
     * @param string|array $json
     * @return static
     */
    public static function fromJson($json)
    {
        if (!is_array($json)) {
            $json = json_decode($json, true);
        }

        return new static($json);
    }

    /**
     * Initialize this from a legacy LibreNMS rule
     *
     * @param string $query
     * @return static
     */
    public static function fromOld($query)
    {
        $condition = null;
        $rules = [];
        $filter = new QueryBuilderFilter();

        $split = array_chunk(preg_split('/(&&|\|\|)/', $query, -1, PREG_SPLIT_DELIM_CAPTURE), 2);

        foreach ($split as $chunk) {
            list($rule_text, $rule_operator) = $chunk;
            if (!isset($condition)) {
                // only allow one condition.  Since old rules had no grouping, this should hold logically
                $condition = ($rule_operator == '||' ? 'OR' : 'AND');
            }

            list($field, $op, $value) = preg_split('/ *([!=<>~]{1,2}) */', trim($rule_text), 2, PREG_SPLIT_DELIM_CAPTURE);
            $field = ltrim($field, '%');

            // for rules missing values just use '= 1'
            $operator = isset(self::$legacy_operators[$op]) ? self::$legacy_operators[$op] : 'equal';
            if (is_null($value)) {
                $value = '1';
            } else {
                $value = trim($value, '"');

                // value is a field, mark it with backticks
                if (starts_with($value, '%')) {
                    $value = '`' . ltrim($value, '%') . '`';
                }

                // replace regex placeholder, don't think we can safely convert to like operators
                if ($operator == 'regex' || $operator == 'not_regex') {
                    $value = str_replace('@', '.*', $value);
                }
            }

            $filter_item = $filter->getFilter($field);

            $type = $filter_item['type'];
            $input = isset($filter_item['input']) ? $filter_item['input'] : 'text';

            $rules[] = [
                'id' => $field,
                'field' => $field,
                'type' => $type,
                'input' => $input,
                'operator' => $operator,
                'value' => $value,
            ];
        }

        $builder = [
            'condition' => $condition,
            'rules' => $rules,
            'valid' => true,
        ];

        return new static($builder);
    }

    /**
     * Get the SQL for this rule, ready to execute with device_id supplied as the parameter
     * If $expand is false, this will return a more readable representation of the rule, but not executable.
     *
     * @param bool $expand
     * @return null|string The rule or null if this is invalid.
     */
    public function toSql($expand = true)
    {
        if (empty($this->builder) || !array_key_exists('condition', $this->builder)) {
            return null;
        }

        $result = [];
        foreach ($this->builder['rules'] as $rule) {
            if (array_key_exists('condition', $rule)) {
                $result[] = $this->parseGroup($rule, $expand);
            } else {
                $result[] = $this->parseRule($rule, $expand);
            }
        }

        $sql = '';
        if ($expand) {
            $sql = 'SELECT * FROM ' . implode(',', $this->getTables());
            $sql .= ' WHERE ' . $this->generateGlue() . ' AND ';
        }
        return $sql . implode(" {$this->builder['condition']} ", $result);
    }

    /**
     * Parse a rule group
     *
     * @param $rule
     * @param bool $expand Expand macros?
     * @return string
     */
    private function parseGroup($rule, $expand = false)
    {
        $group_rules = [];

        foreach ($rule['rules'] as $group_rule) {
            if (array_key_exists('condition', $group_rule)) {
                $group_rules[] = $this->parseGroup($group_rule, $expand);
            } else {
                $group_rules[] = $this->parseRule($group_rule, $expand);
            }
        }

        $sql = implode(" {$rule['condition']} ", $group_rules);
        return "($sql)";
    }

    /**
     * Parse a rule
     *
     * @param $rule
     * @param bool $expand Expand macros?
     * @return string
     */
    private function parseRule($rule, $expand = false)
    {
        $op = self::$operators[$rule['operator']];
        $value = $rule['value'];

        if (starts_with($value, '`') && ends_with($value, '`')) {
            // pass through value such as field
            $value = trim($value, '`');
            $value = $this->expandMacro($value); // check for macros
        } elseif ($rule['type'] != 'integer' && !str_contains($op, '?')) {
            $value = "\"$value\"";
        }

        $field = $rule['field'];
        if ($expand) {
            $field = $this->expandMacro($field);
        }

        if (str_contains($op, '?')) {
            // op with value inside it aka IN and NOT IN
            $sql = "$field " . str_replace('?', $value, $op);
        } else {
            $sql = "$field $op $value";
        }


        return $sql;
    }

    /**
     * Expand macro to sql
     *
     * @param $subject
     * @param bool $tables_only Used when finding tables in query returns an array instead of sql string
     * @param int $depth_limit
     * @return string|array
     */
    private function expandMacro($subject, $tables_only = false, $depth_limit = 20)
    {
        if (!str_contains($subject, 'macros.')) {
            return $subject;
        }

        $macros = Config::get('alert.macros.rule');

        $count = 0;
        while ($count++ < $depth_limit && str_contains($subject, 'macros.')) {
            $subject = preg_replace_callback('/%?macros.([^ =()]+)/', function ($matches) use ($macros) {
                $name = $matches[1];
                if (isset($macros[$name])) {
                    return $macros[$name];
                } else {
                    return $matches[0]; // this isn't a macro, don't replace
                }
            }, $subject);
        }

        if ($tables_only) {
            preg_match_all('/%([^%.]+)\./', $subject, $matches);
            return array_unique($matches[1]);
        }

        // clean leading %
        $subject = preg_replace('/%([^%.]+)\./', '$1.', $subject);

        // wrap entire macro result in parenthesis if needed
        if (!(starts_with($subject, '(') && ends_with($subject, ')'))) {
            $subject = "($subject)";
        }

        return $subject;
    }


    /**
     * Generate glue and first part of sql query for this rule
     *
     * @param string $target the name of the table to target, for alerting, this should be devices
     * @return string
     */
    private function generateGlue($target = 'devices')
    {
        $tables = $this->getTables();  // get all tables in query

        // always add the anchor to the target table
        $anchor = $target . '.' . $this->schema->getPrimaryKey($target) . ' = ?';
        $glue = [$anchor];

        foreach ($tables as $table) {
            $path = $this->schema->findRelationshipPath($table, $target);
            if ($path) {
                foreach (array_pairs($path) as $pair) {
                    list($left, $right) = $pair;
                    $glue[] = $this->getGlue($left, $right);
                }
            }
        }

        // remove duplicates
        $glue = array_unique($glue);

        return '(' . implode(' AND ', $glue) . ')';
    }

    /**
     * Get glue sql between tables. Resolve fields to use.
     *
     * @param string $parent
     * @param string $child
     * @return string
     */
    public function getGlue($parent, $child)
    {
        // first check to see if there is a single shared column name ending with _id
        $shared_keys = array_filter(array_intersect(
            $this->schema->getColumns($parent),
            $this->schema->getColumns($child)
        ), function ($table) {
            return ends_with($table, '_id');
        });

        if (count($shared_keys) === 1) {
            $shared_key = reset($shared_keys);
            return "$parent.$shared_key = $child.$shared_key";
        }

        $parent_key = $this->schema->getPrimaryKey($parent);
        $flipped = empty($parent_key);
        if ($flipped) {
            // if the "parent" table doesn't have a primary key, flip them
            list($parent, $child) = [$child, $parent];
            $parent_key = $this->schema->getPrimaryKey($parent);
        }
        $child_key = $parent_key;  // assume the column names match

        if (!$this->schema->columnExists($child, $child_key)) {
            // if they don't match, guess the column name from the parent
            if (ends_with($parent, 'xes')) {
                $child_key = substr($parent, 0, -2) . '_id';
            } else {
                $child_key = preg_replace('/s$/', '_id', $parent);
            }

            if (!$this->schema->columnExists($child, $child_key)) {
                echo"FIXME: Could not make glue from $child to $parent\n";
            }
        }

        if ($flipped) {
            return "$child.$child_key = $parent.$parent_key";
        }

        return "$parent.$parent_key = $child.$child_key";
    }

    /**
     * Get an array of this rule ready for jQuery QueryBuilder
     *
     * @return array
     */
    public function toArray()
    {
        return $this->builder;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->builder;
    }
}
