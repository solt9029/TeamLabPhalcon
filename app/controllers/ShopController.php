<?php

use Phalcon\Mvc\Controller;

class ShopController extends Controller{
	public function indexAction(){

	}

	public function createAction(){

	}

	public function editAction(){

	}

	//商品登録画面
	public function registerAction(){

	}

	//商品登録処理
	public function addAction(){
		
	}

	public function getAction(){
		if($this->request->getQuery("id","int")){
			$id=$this->request->getQuery("id","int");
			$shop=Shops::findFirst($id);

			if(!$shop){
				return false;
			}

			$shop=json_encode($shop,JSON_NUMERIC_CHECK);
			$this->response->setContentType("application/json","UTF-8");
			return $shop;
		}

		$shops=Shops::find();
		$shops=$shops->toArray();
		$shops=json_encode($shops,JSON_NUMERIC_CHECK);
		$this->response->setContentType("application/json","UTF-8");
		return $shops;
	}

	public function storeAction(){
		if(!$this->request->isPost()){
			return;
		}

		$shop=new Shops();
		$post=$this->request->getPost();

		$success=$shop->save(
			array("name"=>$post["name"]),
			array("name")
		);

		if($success){
			echo "success!"."<br>";
		}else{
			echo "The following problems were generated!"."<br>";
			foreach($shop->getMessages() as $message){
				echo $message->getMessage()."<br>";
			}
		}

		echo "<a href='/shop'>戻る</a>";

		$this->view->disable();
	}

	public function updateAction(){
		if(!$this->request->isPost()){
			return;
		}

		$post=$this->request->getPost();
		$shop=Shops::findFirst($post["id"]);

		$shop->name=$post["name"];

		$success=$shop->save();

		if($success){
			echo "success!"."<br>";
		}else{
			echo "The following problems were generated!"."<br>";
			foreach($shop->getMessages() as $message){
				echo $message->getMessage()."<br>";
			}
		}

		echo "<a href='/shop'>戻る</a>";

		$this->view->disable();
	}

	public function destroyAction(){
		//POSTじゃなかったら終了処理
		if(!$this->request->isPost()){
			return;
		}

		$post=$this->request->getPost();
		$id=$post["id"];
		$shop=Shops::findFirst($id);

		//htmlが書き換えられたりして、destroy対象のidが存在しない場合はトップに戻るよ
		if(!$shop){
			header("location:/product");
		}

		if($shop->delete()){
			echo "success!"."<br>";
		}else{
			echo "The following problems were generated!";
			foreach($shop->getMessages() as $message){
				echo $message->getMessage()."<br>";
			}
		}

		echo "<a href='/shop'>戻る</a>";

		$this->view->disable();
	}
}