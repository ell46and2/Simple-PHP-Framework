<?php

namespace App\Core;

class Router {

	protected $routes = [

		'GET' => [],

		'POST' => []

	];

	public function get($uri, $controller) {
		$this->routes['GET'][$uri] = $controller;
	}

	public function post($uri, $controller) {
		$this->routes['POST'][$uri] = $controller;
	}

	public static function load($file) {

		$router = new static; // instance of self, so new Router instance.
		
		require $file;


		return $router;
	}

	public function define($routes) {
		$this->routes = $routes;
	}

	public function direct($uri, $requestType) {
		if (array_key_exists($uri, $this->routes[$requestType])) {

			return $this->callAction(
				...explode('@', $this->routes[$requestType][$uri])
			);
			// explode breaks the string into an array of strings with a delimiter of '@'
			// ... unpacks the function as arguments
			// so return $this->callAction('PagesController', 'home')
					
		}

		throw new Exception('No route defined for this URI.');
	}

	protected function callAction($controller, $action) {

		$controller = "App\\Controllers\\{$controller}";

		$controller = new $controller;
		
		if (! method_exists($controller, $action)) {
			throw new Exception("{$controller} does not respond to the {$action} action.");
		}

		return $controller->$action();
	}


}