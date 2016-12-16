<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Command;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\LockHandler;

class LockableTraitTest extends \PHPUnit_Framework_TestCase
{
    protected static $fixturesPath;

    public static function setUpBeforeClass()
    {
        self::$fixturesPath = __DIR__.'/../Fixtures/';
        require_once self::$fixturesPath.'/FooLockCommand.php';
        require_once self::$fixturesPath.'/FooLock2Command.php';
    }

    public function testLockIsReleased()
    {
        $command = new \FooLockCommand();

        $tester = new CommandTester($command);
        $this->assertSame(2, $tester->execute(array()));
        $this->assertSame(2, $tester->execute(array()));
    }

    public function testLockReturnsFalseIfAlreadyLockedByAnotherCommand()
    {
        $command = new \FooLockCommand();

        $lock = new LockHandler($command->getName());
        $lock->lock();

        $tester = new CommandTester($command);
        $this->assertSame(1, $tester->execute(array()));

        $lock->release();
        $this->assertSame(2, $tester->execute(array()));
    }

    public function testMultipleLockCallsThrowLogicException()
    {
        $command = new \FooLock2Command();

        $tester = new CommandTester($command);
        $this->assertSame(1, $tester->execute(array()));
    }
}
