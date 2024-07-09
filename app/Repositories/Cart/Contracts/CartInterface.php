<?php namespace App\Repositories\Cart\Contracts;

interface CartInterface {

	public function add($item);
	public function content();
	public function update($itemId, $data);

}