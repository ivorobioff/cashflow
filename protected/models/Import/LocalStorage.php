<?php
namespace Models\Import;

interface LocalStorage
{
	public function addBunch(array $data);
	public function getLastDate($user_id);
}