<?php namespace App\Repositories\Item\Contracts;

interface ItemInterface {


	public function getItemVariation($itemId);
	public function createItemVariation($storeId, $sku);
	public function getItemsWithSameCategory($itemId);
	public function getItemPrice($item, $itemEvent);

}