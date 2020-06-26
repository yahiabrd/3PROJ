<?php
require_once('views/View.php');

/**
 * class Controller for the Monitoring administration
 */
class MonitoringController
{
	private $_monitoringManager;
	private $_view;

	public function __construct($url)
	{
		if(isset($url) && is_array($url) && sizeof($url) > 1)
			throw new Exception("Page not found");
		else 
		{
			if(isset($_GET['param']) && !empty($_GET['param']))
			{
				$param = explode('/', filter_var($_GET['param'], FILTER_SANITIZE_URL));

				if(is_array($param) && sizeof($param) == 1 && $param[0] == 1)
					$this->stats();
				else if(is_array($param) && sizeof($param) == 1 && $param[0] == 2)
					$this->users();
				else if(is_array($param) && sizeof($param) == 1 && $param[0] == 3)
					$this->analysis();
				else if(is_array($param) && sizeof($param) == 1 && $param[0] == 4)
					$this->backup();
				else if(is_array($param) && sizeof($param) == 1 && $param[0] == 5)
					$this->analysisForm();
				else
					throw new Exception("Page not found");

			}else
				$this->stats();
		}
	}

	/**
	 * controller function for the stats page 
	 */
	public function stats()
	{
		$this->_monitoringManager = new StatManager;
		$stats = $this->_monitoringManager->getStats();
		$nbT = $this->_monitoringManager->getTotalAttacks();
		$nbD = $this->_monitoringManager->getTotalAttacksByDay();
		$nbM = $this->_monitoringManager->getTotalAttacksByMonth();
		$nbY = $this->_monitoringManager->getTotalAttacksByYear();
		$stats2 = $this->_monitoringManager->getAttacksBySections();
		
		
		$this->_view = new View('Stats');
		$this->_view->generate(array('stats' => $stats, 'stats2' => $stats2, 'nbT' => $nbT, 'nbD' => $nbD, 'nbM' => $nbM, 'nbY' => $nbY));
	}

	/**
	 * controller function for the users page 
	 */
	public function users()
	{
		$this->_monitoringManager = new UserManager;
		$users = $this->_monitoringManager->getUsers();
		$nb = $this->_monitoringManager->getNbAllUsers();

		$this->_view = new View('Users');
		$this->_view->generate(array('users' => $users, 'nb' => $nb));
	}

	/**
	 * controller function for the analysis page 
	 */
	public function analysis()
	{
		$this->_monitoringManager = new StatManager;
		$threats = $this->_monitoringManager->getAllThreats();
		$nb = $this->_monitoringManager->getNbAllThreats();

		$this->_view = new View('Analysis');
		$this->_view->generate(array('threats' => $threats, 'nb' => $nb));
	}

	/**
	 * controller function for the backup
	 */
	public function backup()
	{
		$this->_monitoringManager = new BackupManager;
		$backups = $this->_monitoringManager->getBackups();
		$nb = $this->_monitoringManager->getNbAllBackups();

		$this->_view = new View('Backup');
		$this->_view->generate(array('backups' => $backups, 'nb' => $nb));
	}

	/**
	 * controller function for the analysis IP form
	 */
	public function analysisForm() 
	{
		if(isset($_POST['ip']) && !empty($_POST['ip']))
		{
			$ip = $_POST['ip'];
			$this->_monitoringManager = new StatManager;
			$filters = $this->_monitoringManager->getFilterByIp($ip);
			
			$this->_view = new View('AnalysisIP');
			$this->_view->generate(array('nb' => $filters[0], 'filters' => $filters[1], 'ip' => $ip));
		}else{
			$this->analysis();
		}
	}
}