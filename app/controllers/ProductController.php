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
		$filename=time().uniqid().".png";
		move_uploaded_file($tmpname,"./product_images/".$filename);

		$post=$this->request->getPost();

		$success=$product->save(
			array("image"=>$filename,"title"=>$post["title"],"description"=>$post["description"],"price"=>$post["price"]),
			array("image","title","description","price")
		);

		if($success){
			echo "success!";
		}else{
			echo "The following problems were generated!";
			foreach($product->getMessages() as $message){
				echo $message->getMessage();
			}
		}

		$this->view->disable();
	}

	//更新処理
	public function updateAction(){

	}

	//削除処理
	public function destroyAction(){

	}

}
