<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\File as FileValidator;

class Products extends Model
{

	public $id;

	public $image;

	public $title;

	public $description;

	public $price;

	public function initialize(){
		$this->hasMany(
			"id",
			"ShopsProducts",
			"shops_id"
		);
	}

	public function validation(){
		$validator=new Validation();

		$validator->add(
			"image",
			new PresenceOf(
				[
					"message"=>"image required"
				]
			)
		);	

		$validator->add(
			"price",
			new Numericality(
				[
					"message"=>"price number only"
				]
			)
		);

		$validator->add(
			"price",
			new PresenceOf(
				[
					"message"=>"price required"
				]
			)
		);		

		$validator->add(
			"description",
			new StringLength(
				[
					"max"=>500,
					"messageMaximum"=>"description less than 500"
				]
			)
		);

		$validator->add(
			"description",
			new PresenceOf(
				[
					"message"=>"description required"
				]
			)
		);

		$validator->add(
			"title",
			new StringLength(
				[
					"max"=>100,
					"messageMaximum"=>"title less than 100"
				]
			)
		);

		$validator->add(
			"title",
			new PresenceOf(
				[
					"message"=>"title required"
				]
			)
		);

		return $this->validate($validator);
	}
}
