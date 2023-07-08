<?php

namespace LibreNMS\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use SnmpsimHelpers;

    public function __construct(string $name)
    {
        parent::__construct($name);
        // grab global $snmpsim from bootstrap and make it accessible
        $this->getSnmpsim();
    }

    public function dbSetUp()
    {
        if (getenv('DBTEST')) {
            \LibreNMS\DB\Eloquent::DB()->beginTransaction();
        } else {
            $this->markTestSkipped('Database tests not enabled.  Set DBTEST=1 to enable.');
        }
    }

    public function dbTearDown()
    {
        if (getenv('DBTEST')) {
            try {
                \LibreNMS\DB\Eloquent::DB()->rollBack();
            } catch (\Exception $e) {
                $this->fail("Exception when rolling back transaction.\n" . $e->getTraceAsString());
            }
        }
    }

    protected function tearDown(): void
    {
        $this->beforeApplicationDestroyed(function () {
            $this->getConnection()->disconnect();
        });

        parent::tearDown();
    }
}
