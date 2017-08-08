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

	//色々と指定すると商品情報が返ってくるAPI(json)
	public function getAction(){
		//id指定でのget
		if($this->request->getQuery("id","int")){
			$id=$this->request->getQuery("id","int");
			$product=Products::findFirst($id);

			//見つからなかったらfalseを返す
			if(!$product){
				return false;
			}

			$product=json_encode($product,JSON_NUMERIC_CHECK);
			$this->response->setContentType("application/json","UTF-8");
			return $product;
		}

		//全てを返す
		$products=Products::find();
		$products=$products->toArray();
		$products=json_encode($products,JSON_NUMERIC_CHECK);
		$this->response->setContentType('application/json', 'UTF-8');
		return $products;
	}

	//新規作成したものを保存する
	public function storeAction(){
		//POSTじゃなかったら終了処理
		if(!$this->request->isPost()){
			return;
		}

		$tmpname=$_FILES["image"]["tmp_name"];

		//画像絶対必要
		if(!$tmpname){
			echo "image required"."<br>";
			echo "<a href='/product'>戻る</a>";
			return;
		}

		$extension=array_search(mime_content_type($tmpname),array(
			"gif"=>"image/gif",
			"jpg"=>"image/jpeg",
			"png"=>"image/png"
		),true);

		//形式がpng,jpeg,gif以外だったら処理終了
		if(!$extension){
			echo "image gif,jpeg,png only"."<br>";
			echo "<a href='/product'>戻る</a>";
			return;
		}

		//ファイルサイズvalidationがあっても良いかも（省略）

		//product_imagesフォルダに保存する
		$filename=time().uniqid().".".$extension;
		move_uploaded_file($tmpname,"./product_images/".$filename);

		//画像以外のバリデーションをする
		$product=new Products();
		$post=$this->request->getPost();

		$success=$product->save(
			array("image"=>$filename,"title"=>$post["title"],"description"=>$post["description"],"price"=>$post["price"]),
			array("image","title","description","price")
		);

		if($success){
			echo "success!"."<br>";
		}else{
			echo "The following problems were generated!"."<br>";
			foreach($product->getMessages() as $message){
				echo $message->getMessage()."<br>";
			}
		}

		echo "<a href='/product'>戻る</a>";

		$this->view->disable();
	}

	//更新処理
	public function updateAction(){
		//POSTじゃなかったら終了処理
		if(!$this->request->isPost()){
			return;
		}

		$post=$this->request->getPost();
		$product=Products::findFirst($post["id"]);

		$tmpname=$_FILES["image"]["tmp_name"];

		//画像がある場合には、形式を確認したりする。ない場合には前の画像をそのままにする
		if($tmpname){
			$extension=array_search(mime_content_type($tmpname),array(
				"gif"=>"image/gif",
				"jpg"=>"image/jpeg",
				"png"=>"image/png"
			),true);

			//形式がpng,jpeg,gif以外だったら処理終了
			if(!$extension){
				echo "image gif,jpeg,png only"."<br>";
				echo "<a href='/product'>戻る</a>";
				return;
			}

			//ファイルサイズvalidationがあっても良いかも（省略）

			//product_imagesフォルダに保存する
			$filename=time().uniqid().".".$extension;
			move_uploaded_file($tmpname,"./product_images/".$filename);

			$product->image=$filename;
		}

		$product->title=$post["title"];
		$product->description=$post["description"];
		$product->price=$post["price"];

		$success=$product->save();

		if($success){
			echo "success!"."<br>";
		}else{
			echo "The following problems were generated!"."<br>";
			foreach($product->getMessages() as $message){
				echo $message->getMessage()."<br>";
			}
		}

		echo "<a href='/product'>戻る</a>";

		$this->view->disable();
	}

	//削除処理
	public function destroyAction(){
		//POSTじゃなかったら終了処理
		if(!$this->request->isPost()){
			return;
		}

		$post=$this->request->getPost();
		$id=$post["id"];
		$product=Products::findFirst($id);

		//htmlが書き換えられたりして、destroy対象のidが存在しない場合はトップに戻るよ
		if(!$product){
			header("location:/product");
		}

		if($product->delete()){
			echo "success!"."<br>";

			/*** shops_productsテーブルの中から削除したやつと同じproducts_idのものを削除するよ！ ***/
			$shopsProducts=ShopsProducts::find(
				[
					"products_id = :products_id:",
					"bind" => [
						"products_id" => $id
					]
				]
			);

			foreach($shopsProducts as $shopProduct){
				$success=$shopProduct->delete();

				//削除が失敗してたらエラー出す
				if(!$success){
					echo "The following problems were generated!";
					foreach($shopProduct->getMessages() as $message){
						echo $message->getMessage()."<br>";
					}
				}
			}
			/*** shops_productsテーブルの中から削除したやつと同じproducts_idのものを削除するよ！ ***/

		}else{
			echo "The following problems were generated!";
			foreach($product->getMessages() as $message){
				echo $message->getMessage()."<br>";
			}
		}

		echo "<a href='/product'>戻る</a>";

		$this->view->disable();
	}

}
