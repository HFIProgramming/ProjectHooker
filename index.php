<?php

require_once __DIR__ . '/class/loader.php';

$result = new split($_SERVER['REQUEST_URI']);

error_reporting(0);

$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

if (empty($result->parameter)) {
	http_response_code(404);
	exit();
}

if (!empty($projectName = $result->slash['project'])) {

	// get Config
	$config = new config($projectName);
	if ($config->config == false) {
		echo 'Project No Found';
		http_response_code(404);
		exit();
	}

	// True?
	if ($signature) {
		$hash = "sha1=" . hash_hmac('sha1', $payload = file_get_contents("php://input"), $config->config['secret']);
		if (strcmp($signature, $hash) == 0) {

			// Looks fine, init
			// get Command
			$command = new command(
				$config->config['commandPackage'],
				$config->config['templateVariable'],
				$config->getBasicVariable()
			);

			// Create log
			$time = time();
			$log = [];
			$logFilePath = $path . '/' . $projectName . '-' . $time . '.log';

			// Exec
			foreach ($command->commands as $command) {
				$log[$command] = shell_exec($command);  // Exec
			}

			if (!empty($path = $config->config['logPath'])) {
				file_put_contents($logFilePath, packLog($log)); // Write Log
			}

			echo json_encode($log);

			// Post Command
			$postLog = [];
			if (!empty($config->config['postCommandPackage'])) {
				$postCommand = new command(
					$config->config['postCommandPackage'],
					$config->config['postCommandVariable'],
					['logFilePath' => $logFilePath],
					$config->getBasicVariable()
				);
				foreach ($command->commands as $command) {
					$postLog[$command] = shell_exec($command);  // Exec
				}
				if (!empty($path = $config->config['logPath'])) {
					file_put_contents($path . '/' . $projectName . '-postCommand-' . $time . '.log', packLog($log)); // Write Log
				}
			}
			exit();
		} else {
			http_response_code(403);
			exit();
		}
	} else {
		http_response_code(404);
		exit();
	}
} else {
	http_response_code(404);
	exit();
}


function packLog($log)
{
	return json_encode($log);
}