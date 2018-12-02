<?php
namespace app\Main\controller;
use think\worker\Server;
/**
 * 
 */
class Worker extends Server
{
	protected $socket = 'http://0.0.0.0:2346';

	public function onMessage($connection,$data)
	{
		$connection->send(json_encode($data));
	}

	public function onWorkerStart(){
		echo 'Worker is opening...';
	}
}