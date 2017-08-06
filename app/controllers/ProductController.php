<?php

use Phalcon\Mvc\Controller;

class ProductController extends Controller{

	//一覧を表示する→create/show
	public function indexAction(){
		
	}

	//新規作成画面→store
	public function createAction(){

	}

	//更新のための編集画面→update
	public function editAction(){

	}

	//一つの記事を表示する→edit/destroy
	public function showAction(){

	}

	//新規作成したものを保存する
	public function storeAction(){
		$product=new Products();

		$tmpname=$_FILES["image"]["tmp_name"];
		$filename="./product_images/".time().uniqid().".png";
		move_uploaded_file($tmpname,$filename);

		$post=$this->request->getPost();

		$success=$product->save(
			array($filename,$post["title"],$post["description"],$post["price"]),
			array("image","title","description","price")
		);
	}

	/*
	public function registerAction()
	{

		$user = new Users();

		// Store and check for errors
		$success = $user->save(
			$this->request->getPost(),
			array('name', 'email')
		);

		if ($success) {
			echo "Thanks for registering!";
		} else {
			echo "Sorry, the following problems were generated: ";
			foreach ($user->getMessages() as $message) {
				echo $message->getMessage(), "<br/>";
			}
		}

		$this->view->disable();
	}
	*/

	//更新処理
	public function updateAction(){

	}

	//削除処理
	public function destroyAction(){

	}

}
