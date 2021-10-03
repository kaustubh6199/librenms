<?php

namespace LibreNMS\Tests\Unit;

use App\Models\Device;
use LibreNMS\Config;
use LibreNMS\Data\Source\Fping;
use LibreNMS\Data\Source\FpingResponse;
use LibreNMS\Data\Source\SnmpResponse;
use LibreNMS\Polling\ConnectivityHelper;
use LibreNMS\Tests\TestCase;

class ConnectivityHelperTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testDeviceStatus()
    {
        // not called when ping is disabled
        $this->app->singleton(Fping::class, function ($app) {
            $mock = \Mockery::mock(\LibreNMS\Data\Source\Fping::class);
            $up = FpingResponse::artificialUp();
            $down = new FpingResponse(1, 0, 100, 0, 0, 0, 0, 0);
            $mock->shouldReceive('ping')
                ->times(8)
                ->andReturn(
                    $up,
                    $down,
                    $up,
                    $down,
                    $up,
                    $down,
                    $up,
                    $down
                );

            return $mock;
        });

        // not called when snmp is disabled or ping up
        $up = new SnmpResponse('SNMPv2-MIB::sysObjectID.0 = .1');
        $down = new SnmpResponse('', '', 1);
        \NetSnmp::partialMock()->shouldReceive('get')
            ->times(6)
            ->andReturn(
                $up,
                $down,
                $up,
                $up,
                $down,
                $down
            );

        global $mark;
        $device = new Device();

        /** ping and snmp enabled */
        Config::set('icmp_check', true);
        $device->snmp_disable = false;

        // ping up, snmp up
        $ch = new ConnectivityHelper($device);
        $this->assertTrue($ch->isUp());
        $this->assertEquals(true, $device->status);
        $this->assertEquals('', $device->status_reason);

        // ping down, snmp up
        $this->assertFalse($ch->isUp());
        $this->assertEquals(false, $device->status);
        $this->assertEquals('icmp', $device->status_reason);

        // ping up, snmp down
        $this->assertFalse($ch->isUp());
        $this->assertEquals(false, $device->status);
        $this->assertEquals('snmp', $device->status_reason);

        // ping down, snmp down
        $this->assertFalse($ch->isUp());
        $this->assertEquals(false, $device->status);
        $this->assertEquals('icmp', $device->status_reason);

        /** ping disabled and snmp enabled */
        Config::set('icmp_check', false);
        $device->snmp_disable = false;

        // ping up, snmp up
        $this->assertTrue($ch->isUp());
        $this->assertEquals(true, $device->status);
        $this->assertEquals('', $device->status_reason);

        // ping down, snmp up
        $this->assertTrue($ch->isUp());
        $this->assertEquals(true, $device->status);
        $this->assertEquals('', $device->status_reason);

        $mark = true;
        // ping up, snmp down
        $this->assertFalse($ch->isUp());
        $this->assertEquals(false, $device->status);
        $this->assertEquals('snmp', $device->status_reason);

        // ping down, snmp down
        $this->assertFalse($ch->isUp());
        $this->assertEquals(false, $device->status);
        $this->assertEquals('snmp', $device->status_reason);

        /** ping enabled and snmp disabled */
        Config::set('icmp_check', true);
        $device->snmp_disable = true;

        // ping up, snmp up
        $this->assertTrue($ch->isUp());
        $this->assertEquals(true, $device->status);
        $this->assertEquals('', $device->status_reason);

        // ping down, snmp up
        $this->assertFalse($ch->isUp());
        $this->assertEquals(false, $device->status);
        $this->assertEquals('icmp', $device->status_reason);

        // ping up, snmp down
        $this->assertTrue($ch->isUp());
        $this->assertEquals(true, $device->status);
        $this->assertEquals('', $device->status_reason);

        // ping down, snmp down
        $this->assertFalse($ch->isUp());
        $this->assertEquals(false, $device->status);
        $this->assertEquals('icmp', $device->status_reason);

        /** ping and snmp disabled */
        Config::set('icmp_check', false);
        $device->snmp_disable = true;

        // ping up, snmp up
        $this->assertTrue($ch->isUp());
        $this->assertEquals(true, $device->status);
        $this->assertEquals('', $device->status_reason);

        // ping down, snmp up
        $this->assertTrue($ch->isUp());
        $this->assertEquals(true, $device->status);
        $this->assertEquals('', $device->status_reason);

        // ping up, snmp down
        $this->assertTrue($ch->isUp());
        $this->assertEquals(true, $device->status);
        $this->assertEquals('', $device->status_reason);

        // ping down, snmp down
        $this->assertTrue($ch->isUp());
        $this->assertEquals(true, $device->status);
        $this->assertEquals('', $device->status_reason);
    }
}
