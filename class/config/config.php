<?php


class config
{

	public $config;

	public function __construct($projectName)
	{
		include_once __DIR__ . '/' . $projectName . '.config.php';
		if (!empty($config)) {
			$this->config = $config;
		} else {
			$this->config = false;
		}
	}

	public function getConfig()
	{
		return $this->config;
	}

	public function getBasicVariable()
	{
		$basic = [
			'path', 'secret',
		];

		$return = [];
		foreach ($basic as $variable) {
			$return[$variable] = $this->config[$variable];
		}

		return $return;
	}

}
