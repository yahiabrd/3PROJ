<?php

/**
 * class for managing section
 */
class SectionManager extends Model
{
	/**
	 * function for getting all sections
	 */
	public function getSections()
	{
		$sections = [];
		$req = self::getBdd()->query('SELECT * FROM sections');
		
		while($data = $req->fetch(PDO::FETCH_ASSOC)){
			$var[] = new Section($data);
		}

		return $sections;
	}
}