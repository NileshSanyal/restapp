app.service('BookService', function($http,$q,$location){

	var host = $location.host();

	var baseUrl = "http://"+host+"/restapp/restapiback/";


	this.getBooks = function(){
		var defer = $q.defer();

		$http({
			method : 'GET',
			url : baseUrl + 'api/books'
		}).then(function(resp){
			return defer.resolve(resp.data);
		},
		function(error){
			defer.reject();
		});
		
		return defer.promise;
	}

	this.saveBook = function(bookData){
		
		var defer = $q.defer();

		$http({
			method : 'POST',
			url : baseUrl + 'api/addBook',
			data: {
				name: bookData.name,
				author: bookData.author,
				category: bookData.category,
				id: bookData.id,
				language: bookData.language,
				price: bookData.price,
				publish_date: bookData.publish_date,
				ISBN: bookData.ISBN
			},
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			
			}).then(function(resp){
				defer.resolve(resp.data);
			},
			function(error){

				defer.reject(error.data);
			});

			return defer.promise;

	}

	this.editBook = function(bookId){

		var defer = $q.defer();

		$http({
			method : 'GET',
			url : baseUrl + 'api/bookById?id='+bookId
		}).then(function(resp){
			return defer.resolve(resp.data);
		},
		function(error){
			defer.reject(error.data);
		});

		return defer.promise;
	}

	this.deleteBook = function(bookId){
		
		if(confirm("Are you sure you want to remove it?")){
			var defer = $q.defer();
			$http({
				method : 'GET',
				url : baseUrl + 'api/deletebook?id='+bookId,
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function(resp){
				return defer.resolve(resp.data);
			},
			function(error){
				defer.reject(error.data);
			});
			return defer.promise;
		}
	
	}

});