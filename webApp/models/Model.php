<?php

/**
 * class for the database Model
 */
abstract class Model
{
	private static $_bdd;
	//============================================================
	//information must also be updated on the page views/refreshStatus.php
	//============================================================
	private static $_host = "localhost";
	private static $_dbname = "3proj";
	private static $_user = "root";
	private static $_password = "";

	private static function setBdd()
	{
		try{
			self::$_bdd = new PDO('mysql:host='.self::$_host.';dbname='.self::$_dbname.';charset=utf8', self::$_user, self::$_password);
		}catch(Exception $e){
			die ("connection error, not connected to the database");
		}
	}

	protected function getBdd()
	{
		if(self::$_bdd == null)
			self::setBdd();
		return self::$_bdd;
	}
}