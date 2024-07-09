<?php

class CartControllerTest extends TestCase {


	public function testGetItem()
	{

		$d = ['itemId' => 1];

		$response = $this->action('GET', 'CartController@getItem', $d);

		$r = $response->getOriginalContent();

		$this->assertNotEmpty($r['name'], 'message');
		$this->assertNotEmpty($r['id'], 'message');

	}

}