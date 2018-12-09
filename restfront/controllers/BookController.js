app.controller('BookController', function(BookService,$location,$window,$rootScope){

	var self = this;
	self.books = {};
	self.add_book = {};

	self.error = false;

	self.success = false;

	self.getAllBook = function(){
		// self.error = true;
		// self.success = true;
		BookService.getBooks().then(function(data){
			self.books = data;
			
		});
	}

	self.saveBook = function(){
		// console.log(self.add_book);
		BookService.saveBook(self.add_book).then(function(response){
			if(response.status == "false"){

				self.getAllBook();

			}else{
				self.getAllBook();
			}
		});
	}

	self.editBook = function(bookId){
		BookService.editBook(bookId).then(function(response){
			if(response.status == "false"){
				$window.location.href = "/restapp/restfront/allbooks"; 
			}else{
				self.add_book = response;	
			}
		});
	}

	self.deleteBook = function(bookId){
		BookService.deleteBook(bookId).then(function(response){
			if(response.status == "false"){
				self.getAllBook();
			}else{
				self.getAllBook();
			}
		});
	}

});