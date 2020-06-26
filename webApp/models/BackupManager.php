<?php

/**
 * class for managing backup
 */
class BackupManager extends Model
{
	/**
	 * function for getting all backup
	 */
	public function getBackups()
	{
        $data = [];
        
        $req = self::getBdd()->query('SELECT * FROM backup');

        while($results = $req->fetch())
        {
            $informations = [
                "id" => $results["id"],
                "date" => $results["dateBackup"],
                "comment" => $results["commentBackup"]
            ];

            array_push($data, $informations);
        }

        return $data;
    }
    
    /**
	 * funtion for getting all backups
	 */
	public function getNbAllBackups(){
		$query = self::getBdd()->query('SELECT * FROM backup');
		return $query->rowcount();
    }
}