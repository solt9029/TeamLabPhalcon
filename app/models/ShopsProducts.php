<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;

class ShopsProducts extends Model
{

	public $id;

	public $shops_id;

	public $products_id;

	public $number;


	public function initialize(){
		$this->belongsTo(
			"shops_id",
			"Shops",
			"id"
		);

		$this->belongsTo(
			"products_id",
			"Products",
			"id"
		);
	}

	public function validation(){
		$validator=new Validation();

		$validator->add(
			"number",
			new Numericality(
				[
					"message"=>"number number only"
				]
			)
		);

		$validator->add(
			"number",
			new PresenceOf(
				[
					"message"=>"number required"
				]
			)
		);		

		return $this->validate($validator);
	}
}