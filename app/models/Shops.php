<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\PresenceOf;

class Shops extends Model
{

	public $id;

	public $name;

	public function initialize(){
		$this->hasManyToMany(
			"id",
			"ShopsProducts",
			"shops_id","products_id",
			"Products",
			"id"
		);
	}

	public function validation(){
		$validator=new Validation();

		$validator->add(
			"name",
			new PresenceOf(
				[
					"message"=>"name required"
				]
			)
		);

		$validator->add(
			"name",
			new StringLength(
				[
					"max"=>100,
					"messageMaximum"=>"name less than 100"
				]
			)
		);

		return $this->validate($validator);
	}

}
