<?php

/* This file was autogenerated by spec/parser.php - Do not modify */

namespace PhpAmqpLib\Helper\Protocol;

class Wait080
{
    /**
     * @var array
     */
    protected $wait = array(
        'connection.start' => '10,10',
        'connection.start_ok' => '10,11',
        'connection.secure' => '10,20',
        'connection.secure_ok' => '10,21',
        'connection.tune' => '10,30',
        'connection.tune_ok' => '10,31',
        'connection.open' => '10,40',
        'connection.open_ok' => '10,41',
        'connection.redirect' => '10,50',
        'connection.close' => '10,60',
        'connection.close_ok' => '10,61',
        'channel.open' => '20,10',
        'channel.open_ok' => '20,11',
        'channel.flow' => '20,20',
        'channel.flow_ok' => '20,21',
        'channel.alert' => '20,30',
        'channel.close' => '20,40',
        'channel.close_ok' => '20,41',
        'access.request' => '30,10',
        'access.request_ok' => '30,11',
        'exchange.declare' => '40,10',
        'exchange.declare_ok' => '40,11',
        'exchange.delete' => '40,20',
        'exchange.delete_ok' => '40,21',
        'queue.declare' => '50,10',
        'queue.declare_ok' => '50,11',
        'queue.bind' => '50,20',
        'queue.bind_ok' => '50,21',
        'queue.purge' => '50,30',
        'queue.purge_ok' => '50,31',
        'queue.delete' => '50,40',
        'queue.delete_ok' => '50,41',
        'queue.unbind' => '50,50',
        'queue.unbind_ok' => '50,51',
        'basic.qos' => '60,10',
        'basic.qos_ok' => '60,11',
        'basic.consume' => '60,20',
        'basic.consume_ok' => '60,21',
        'basic.cancel' => '60,30',
        'basic.cancel_ok' => '60,31',
        'basic.publish' => '60,40',
        'basic.return' => '60,50',
        'basic.deliver' => '60,60',
        'basic.get' => '60,70',
        'basic.get_ok' => '60,71',
        'basic.get_empty' => '60,72',
        'basic.ack' => '60,80',
        'basic.reject' => '60,90',
        'basic.recover_async' => '60,100',
        'basic.recover' => '60,110',
        'basic.recover_ok' => '60,111',
        'file.qos' => '70,10',
        'file.qos_ok' => '70,11',
        'file.consume' => '70,20',
        'file.consume_ok' => '70,21',
        'file.cancel' => '70,30',
        'file.cancel_ok' => '70,31',
        'file.open' => '70,40',
        'file.open_ok' => '70,41',
        'file.stage' => '70,50',
        'file.publish' => '70,60',
        'file.return' => '70,70',
        'file.deliver' => '70,80',
        'file.ack' => '70,90',
        'file.reject' => '70,100',
        'stream.qos' => '80,10',
        'stream.qos_ok' => '80,11',
        'stream.consume' => '80,20',
        'stream.consume_ok' => '80,21',
        'stream.cancel' => '80,30',
        'stream.cancel_ok' => '80,31',
        'stream.publish' => '80,40',
        'stream.return' => '80,50',
        'stream.deliver' => '80,60',
        'tx.select' => '90,10',
        'tx.select_ok' => '90,11',
        'tx.commit' => '90,20',
        'tx.commit_ok' => '90,21',
        'tx.rollback' => '90,30',
        'tx.rollback_ok' => '90,31',
        'dtx.select' => '100,10',
        'dtx.select_ok' => '100,11',
        'dtx.start' => '100,20',
        'dtx.start_ok' => '100,21',
        'tunnel.request' => '110,10',
        'test.integer' => '120,10',
        'test.integer_ok' => '120,11',
        'test.string' => '120,20',
        'test.string_ok' => '120,21',
        'test.table' => '120,30',
        'test.table_ok' => '120,31',
        'test.content' => '120,40',
        'test.content_ok' => '120,41',
    );

    /**
     * @var string $method
     * @return string
     */
    public function get_wait($method)
    {
        return $this->wait[$method];
    }
}
