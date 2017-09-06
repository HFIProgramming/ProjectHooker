<?php

$config = [
	'secret'              => '',  // Webhook Secret
	'path'                => '', // Project Path
	'logPath'             => '/tmp', // Log Path, Empty means log will not be saved
	'templateVariable'    => [  // Variable You want to define in the command

	],
	'commandPackage'      => [ // Command you want to run
		'deploy',
	],
	'postCommandVariable' => [ // Post Command Variable
		'TelegramBotToken' => 'something',
	],
	'postCommandPackage'  => [ // Exec after finished commandPackage
		'send',
	],
];
