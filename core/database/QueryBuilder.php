<?php

class QueryBuilder {

	protected $pdo;


	public function __construct(PDO $pdo) {

		$this->pdo = $pdo;

	}

	public function selectAll($table) {

		$statement = $this->pdo->prepare("select * from {$table}");

		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_CLASS);
	}

	public function insert($table, $parameters) {
		// insert into $table values $parameters
		// sprintf - Replace the percent (%) sign by a variable passed as an argument
		$sql = sprintf(
			'insert into %s (%s) values (%s)',
			$table,
			implode(', ', array_keys($parameters)),
			':' . implode(', :', array_keys($parameters))
		);
		// insert into users (name) values (:name)

		try {

			$statement = $this->pdo->prepare($sql);
			$statement->execute($parameters);

		} catch (Exception $e) {
			die('Something went wrong, show 404 page');
		}

		
		// var_dump($sql);
	}	
}

?>