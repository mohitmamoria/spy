<?php namespace Owlgrin\Spy;

use Owlgrin\Spy\SpyClient\ClientInterface;
use Config;

class Spy {

	protected $client;
	protected $user;

	public function __construct(ClientInterface $client)
	{
		$this->client = $client;
	}

	public function init($user, $type)
	{
		$this->client = $this->client->init($type);
		$this->user   = $user;

		return $this;
	}

	public function reinit($user, $type)
	{
		if($this->user) return;

		$this->init($user, $type);
	}

	public function getUsers()
	{
		return $this->client->getUsers();
	}

	/**
	 * it stores user in spy client
	 *
	 * @param  [array] $user [details of the user]
	 *
	 * @return [type]       [description]
	 */
	public function storeUser($meta)
	{
		return $this->client->createUser($this->user, $meta);
	}

	/**
	 * create custom event for spy
	 *
	 * @param  [array] $event [details of the event]
	 *
	 * @return [type]        [description]
	 */
	public function createEvent($eventName, $metaData)
	{
		//if event not in array then skip
		if( ! in_array($eventName, Config::get('spy::events'))) return;

		return $this->client->createEvent($eventName, $this->user, $metaData);
	}

}