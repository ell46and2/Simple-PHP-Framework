<?php

use App\Core\App;

App::bind('config', require 'config.php');

App::bind('database', new QueryBuilder(Connection::make(App::get('config')['database'])));

function view($name, $data = []) {

	// extract treats array keys as varaible names and the values as the variable values
	// so extract(['name' => 'Elliot']) creates $name variable with the value 'Elliot'
	extract($data);

	return require "views/{$name}.view.php";
}

function redirect($path) {
	header("Location: /{$path}");
}