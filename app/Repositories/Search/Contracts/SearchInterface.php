<?php namespace App\Repositories\Search\Contracts;

interface SearchInterface {

	public function search($data);

	public function searchByName($query);

	public function sortList($sortRequest, $data);

}