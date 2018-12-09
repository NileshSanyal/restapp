var app = angular.module('restfront', ['ngRoute', 'datatables']);

app.config(function($locationProvider,$routeProvider){

	$locationProvider.html5Mode(true);

	$routeProvider
		.when('/allbooks', {
			templateUrl: 'views/allbooks.html',
			controller: 'BookController as book'
		});

});

