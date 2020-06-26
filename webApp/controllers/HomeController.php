<?php
require_once('views/View.php');

/**
 * class Controller for the Home page 
 */
class HomeController
{
	private $_sectionManager;
	private $_view;

	public function __construct($url)
	{
		if(isset($url) && is_array($url) && sizeof($url) > 1)
			throw new Exception("Page not found");
		else
			$this->sections();
	}

	public function sections()
	{
		$this->_sectionManager = new SectionManager;
		$sections = $this->_sectionManager->getSections();

		$this->_view = new View('Home');
		$this->_view->generate(array('sections' => $sections));
	}
}