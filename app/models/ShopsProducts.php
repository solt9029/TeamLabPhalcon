<?php

use Phalcon\Mvc\Model;
// use Phalcon\Validation;
// use Phalcon\Validation\Validator\StringLength;
// use Phalcon\Validation\Validator\PresenceOf;

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
}