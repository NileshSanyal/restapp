<?php

	class Book_model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		// API: add a book details
		public function add($data){
			// echo 'LINE 11:: model';
			// print_r($data);die;

			if($this->db->insert('tbl_books', $data)){
				return true;
			}
			else{
				return false;
			}
		}

		// API : get book record by ISBN number
		public function getbookbyId($id){

			$this->db->select('id,name, price, author, category, language, ISBN, publish_date')
					->from('tbl_books')
					->where('id', $id);

			$query = $this->db->get();

			if($query->num_rows() == 1){
				return $query->row();
			}
			else{
				return 0;	
			}
			
		}

		// API : get book details by isbn number
		public function getbookbyIsbn($isbn){

			$this->db->select('name, price, author, category, language, ISBN, publish_date')
					->from('tbl_books')
					->where('ISBN', $isbn);

			$query = $this->db->get();

			if($query->num_rows() == 1){
				return $query->row();
			}
			else{
				return 0;	
			}
			
		}

		// API : get list of all books
		public function getallbooks(){
			$this->db->select('id, name, price, author, category, language, ISBN, publish_date')
					 ->from('tbl_books');
			$this->db->order_by('id', 'desc');

			$query = $this->db->get();

			if($query->num_rows() > 0){
				return $query->result_array();
			}
			else{
				return 0;
			}

		}

		// API: update book details
		public function update($id, $data){
			// echo "In update function: LINE 77";
			// print_r($data);die;
			$data = array(
		        'name' => $data['name'],
		        'price' => $data['price'],
		        'author' => $data['author'],
		        'category' => $data['category'],
		        'language' => $data['language'],
		        'ISBN' => $data['isbn'],
		        'publish_date' => $data['publish_date']
			);

			$this->db->set($data)
					 ->where('id', $id)
					 ->update('tbl_books');

			return ($this->db->affected_rows() > 0 ? true : false);

		}

		// API: delete a book record
		public function delete($id){
			$this->db->where('id', $id);
			if($this->db->delete('tbl_books')){
				return true;
			}
			else{
				return false;
			}
		}



	}