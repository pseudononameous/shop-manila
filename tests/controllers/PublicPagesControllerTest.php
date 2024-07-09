<?php

class PublicPagesControllerTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testStore()
	{

		$response = $this->action('GET', 'PublicPagesController@store', 'nike');

	}

}
