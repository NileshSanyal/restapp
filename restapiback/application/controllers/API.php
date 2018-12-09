<?php
	//use Restserver\Libraries\REST_Controller;
// namespace Restserver\Libraries;
	require (APPPATH.'/libraries/REST_Controller.php');
	use Restserver\Libraries\REST_Controller;

	// require(APPPATH.'/libraries/REST_Controller.php');

	class Api extends REST_Controller{

		public function __construct(){

			parent::__construct();

			$this->load->model('book_model');
		}

		// API: create / update a book detail
		// if new isbn is given insert otherwise update existing book details.
		function addBook_post(){
			
			 	$postdata = file_get_contents("php://input");
			    $request = json_decode($postdata);
			    @$id = $request->id;
			    @$name = $request->name;
			    @$price = $request->price;	
			    @$author = $request->author;	
			    @$category = $request->category;	
			    @$isbn = $request->ISBN;	

				if(!$name || !$price || !$author || !$category || !$isbn){
					$this->response(array('status' => "false", 'message' => "Enter complete book information to save"),400);
				}
				else{

					// check if isbn already exists or not
					$bookData = $this->book_model->getbookbyIsbn($isbn);
					if(!empty($bookData)){
						// update
						$result = $this->book_model->update($id,array("name" => $name, "price" => $price, "author" => $author, "category" => $category, "language" => "en", "isbn" => $isbn, "publish_date" => date('Y-m-d')));
						
						if($result == false){
							$this->response(array('status' => "false", 'message' => "Book information not updated"),404);
						}

						else{
							$this->response(array('status' => "true", 'message' => "Book information updated successfully"),200);
							
						}
					}else{ 
						// insert
						$result = $this->book_model->add(array("name" => $name, "price" => $price, "author" => $author, "category" => $category, "language" => "en", "isbn" => $isbn, "publish_date" => date('Y-m-d')));
						if($result == 0){
							$this->response(array('status' => "false", 'message' => "Book information not saved"),404);
						}

						else{
							$this->response(array('status' => "true", 'message' => "Book information saved successfully"),200);
							
						}
					}

				}
			

			

		}

		//API: client sends id and on valid id book information is sent back
		function bookById_get(){
			$id = $this->input->get('id');

			if(!$id){
				$this->response(array('status' => "false", 'message' => "No Book Id was specified"),400);
				exit;
			}

			$result = $this->book_model->getbookbyId($id);

			if($result){
				$this->response($result, 200);

				exit;
			}

			else{
				$this->response(array('status' => "false", 'message' => "Invalid Book Id"),404);
				
				exit;
			}

		}

		// API: delete an existing book
		function deletebook_get(){
			$id = $this->get('id');
			if(!$id){
				$this->response(array('status' => "false", 'message' => "Book Id is missing"),400);
				// $this->response("id is missing", 400);
			}

			else{

				$result = $this->book_model->delete($id);

				if(!$result){
					$this->response(array('status' => "false", 'message' => "Invalid Book Id"),400);
					// $this->response("invalid id", 404);
				}

				else{
					$this->response(array('status' => "true", 'message' => "Book information deleted successfully"),200);
					// $this->response("success", 200);
				}

			}
		}

		// API: update existing book
		function updatebook_put(){

			$name = $this->put('name');

			$price = $this->put('price');

			$author = $this->put('author');

			$category = $this->put('category');

			$language = $this->put('language');

			$isbn = $this->put('isbn');

			$pub_date = $this->put('publish_date');

			$id = $this->put('id');

			if(!$name || !$price || !$author || !$category || !$language || !$isbn || !$id){
				$this->response("Enter complete book information to update", 400);
			}
			else{
				$result = $this->book_model->update($id, array("name" => $name, "price" => $price, "author" => $author, "category" => $category, "language" => $language, "isbn" => $isbn, "publish_date" => $pub_date));
				if($result == 0){
					$this->response("Book information not updated", 404);
				}

				else{
					$this->response("success", 200);
				}

			}

		}
				

		// API: get all books
		function books_get(){
			$result = $this->book_model->getallbooks();

			if($result){
				$this->response($result, 200);
			}

			else{
				$this->response("No record found", 404);	
			}

		}

	}