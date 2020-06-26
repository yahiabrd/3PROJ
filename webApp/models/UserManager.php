<?php

/**
 * class for managing users
 */
class UserManager extends Model
{
	/**
	 * function for getting all users
	 */
	public function getUsers()
	{
		$data = [];
		$informations = [];

		$query = self::getBdd()->query('SELECT * FROM users');
		
		while($results = $query->fetch()){

			$query2 = self::getBdd()->prepare('SELECT * FROM documents WHERE userId = ?');
			$query2->execute(array($results['id']));
			$nbdocs = $query2->rowcount();

			$docs = [];
			while($results2 = $query2->fetch())
			{
				array_push($docs, $results2["documentName"]);
			}
		
			$informations = [
				"id" => $results["id"],
				"firstName" => $results["firstName"],
				"lastName" => $results["lastName"],
				"nbDocs" => $nbdocs,
				"documents" => $docs
			];
			//push
			array_push($data, $informations);
		
		}

		return $data;
	}

	/**
	 * function for getting all nb users
	 */
	public function getNbAllUsers(){
		$query = self::getBdd()->query('SELECT * FROM users');
		return $query->rowcount();
	}
}