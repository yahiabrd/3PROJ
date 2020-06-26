<?php
/**
 * class View for displaying views
 */
class View
{
	private $_file;
	private $_t;

	public function __construct($action)
	{
		$this->_file = 'views/view'.$action.'.php';
	}

	public function generate($data)
	{
		//2 templates available 1 for the Home page and the other for the Monitoring page
		$arrayViews = [ "views/viewMonitoring.php", 
						"views/viewStats.php",
						"views/viewUsers.php",
						"views/viewAnalysis.php",
						"views/viewAnalysisIP.php",
						"views/viewBackup.php"];

		$content = $this->generateFile($this->_file, $data);
		
		//checking which template must be displayed
		$template = (in_array($this->_file, $arrayViews)) ? "templateMonitoring" : "template";

		$view = $this->generateFile('views/'.$template.'.php', array('t' => $this->_t, 'content' => $content));

		echo $view;
	}

	private function generateFile($file, $data)
	{
		if(file_exists($file)){
			extract($data);

			ob_start();

			require $file;

			return ob_get_clean();
		}else
			throw new Exception("File " . $file. ' not found');
			
	}
}