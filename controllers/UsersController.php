<?php

namespace App\Controllers;

use App\Core\App;

class UsersController {

	public function index() {

		$users = App::get('database')->selectAll('users');
		
		return view('users', ['users' => $users]);
	}

	public function store() {
		
		// Insert the user assocaited with the request
		App::get('database')->insert('users', [
			'name' => $_POST['name']
		]);

		// And then redirect back to the users page
		return redirect('users');
	}
}