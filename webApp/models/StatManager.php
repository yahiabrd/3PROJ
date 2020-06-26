<?php
/**
 * class for managing threats and displaying stats
 */
class StatManager extends Model
{
	/**
	 * function for displaying global stats as attack, number of attack
	 */
	public function getStats()
	{
		//empty array who will receive attackname and the occurence of this attack
		$data = [];
		$informationsName = [];
		$informations = [];
		//fetching all singular data from threats and affecting them to the array
		$threats = self::getBdd()->query('SELECT * FROM threats');
		while($dataThreats = $threats->fetch())
		{
			//check if the attackName is not already in the array
			if(!in_array($dataThreats["attackName"], $informationsName)){
				array_push($informationsName, $dataThreats["attackName"]);
			}
		}

		//fetch the nb occurence of each attack
		for($i = 0; $i < sizeof($informationsName); $i++){
			$nbThreats = self::getBdd()->prepare('SELECT * FROM threats WHERE attackName = ?');
			$nbThreats->execute(array($informationsName[$i]));
			$nbT = $nbThreats->rowcount();

			$informations = [
				"label" => $informationsName[$i],
				"y" => $nbT
			];

			array_push($data, $informations); //save informations
		}
		return $data;
	}

	/**
	 * function for displaying the stats of attacked sections
	 */
	public function getAttacksBySections()
	{
		$data = [];
		$informationsSections = [];
		$informations = [];

		$query = self::getBdd()->query('SELECT * from threats, sections WHERE threats.sectionId = sections.id');
		while($results = $query->fetch()){
			//check if the sectionName is not already in the array
			if(!in_array($results["sectionName"], $informationsSections)){
				array_push($informationsSections, $results["sectionName"]);
			}
		}

		for($i = 0; $i < sizeof($informationsSections); $i++){
			$nbThreats = self::getBdd()->prepare('SELECT * FROM threats, sections WHERE sectionName = ? AND threats.sectionId = sections.id');
			$nbThreats->execute(array($informationsSections[$i]));
			$nbT = $nbThreats->rowcount();

			$informations = [
				"label" => $informationsSections[$i],
				"y" => $nbT
			];

			array_push($data, $informations); //save informations
		}

		return $data;
	}

	/**
	 * function for getting all attacks number 
	 */
	public function getTotalAttacks()
	{
		$nbThreats = self::getBdd()->query('SELECT * FROM threats');
		$nbT = $nbThreats->rowcount();
		return $nbT;
	}

	/**
	 * function for getting all attacks by day
	 */
	public function getTotalAttacksByDay()
	{
		$date = strval(date("Y-m-d"));
		$nbThreats = self::getBdd()->prepare('SELECT * FROM threats WHERE attackDate = ?');
		$nbThreats->execute(array($date));
		$nbT = $nbThreats->rowcount();
		return $nbT;
	}

	/**
	 * function for getting all attacks by month
	 */
	public function getTotalAttacksByMonth()
	{
		$date = strval(date("m"));
		$nbThreats = self::getBdd()->prepare('SELECT * FROM threats WHERE Month(attackDate) = ?');
		$nbThreats->execute(array($date));
		$nbT = $nbThreats->rowcount();
		return $nbT;
	}

	/**
	 * function for getting all attacks by year
	 */
	public function getTotalAttacksByYear()
	{
		$date = strval(date("Y"));
		$nbThreats = self::getBdd()->prepare('SELECT * FROM threats WHERE Year(attackDate) = ?');
		$nbThreats->execute(array($date));
		$nbT = $nbThreats->rowcount();
		return $nbT;
	}

	/**
	 * function for getting all attacks and the attacked sections by all threats
	 */
	public function getAllThreats(){
		$data = [];
		$informations = [];

		$query = self::getBdd()->query('SELECT *, t.id as tid, s.id as secid from threats t, sections s WHERE t.sectionId = s.id ORDER BY t.sectionId DESC');
		while($results = $query->fetch()){
		
			$informations = [
				"id" => $results["tid"],
				"attackName" => $results["attackName"],
				"attackDate" => $results["attackDate"],
				"sectionId" => $results["sectionName"],
				"ip" => $results["ip"]
			];
			//push
			array_push($data, $informations);
		
		}

		return $data;
	}

	/**
	 * function for filtering all attacks by ip
	 */
	public function getFilterByIp($ip){
		$data = [];
		$informations = [];

		$query = self::getBdd()->prepare('SELECT *, t.id as tid, s.id as secid from threats t, sections s WHERE t.sectionId = s.id AND t.ip = ?');
		$query->execute(array($ip));
		while($results = $query->fetch()){
		
			$informations = [
				"id" => $results["tid"],
				"attackName" => $results["attackName"],
				"attackDate" => $results["attackDate"],
				"sectionId" => $results["sectionName"],
				"ip" => $results["ip"]
			];
			//push
			array_push($data, $informations);
		
		}

		$rows = $query->rowcount();

		return [$rows, $data];
	}

	/**
	 * funtion for getting all attacks (threats)
	 */
	public function getNbAllThreats(){
		$query = self::getBdd()->query('SELECT * FROM threats');
		return $query->rowcount();
	}
}