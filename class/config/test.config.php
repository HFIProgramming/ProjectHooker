<?php

$config = [
	'secret'              => '',  // Webhook Secret
	'path'                => '', // Project Path
	'logPath'             => '/tmp', // Log Path
	'templateVariable'    => [  // Variable You want to define in the command.
		'something' => 'Memo',
	],
	'commandPackage'      => [ // Command you want to run
		'test',
	],
	'postCommandVariable' => [
	],
	'postCommandPackage'  => [ // Exec after finished commandPackage

	],
];
