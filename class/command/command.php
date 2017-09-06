<?php

/**
 * Created by PhpStorm.
 * User: NeverBehave
 * Date: 2017/9/6
 * Time: 下午4:00
 */
class command
{
	public $packs;
	public $commands;
	public $postCommands;
	public $templateVariable;
	public $postCommandVariable;
	public $projectBasicVariable;
	public $runtimeVariable;

	public function __construct(array $packs, array $templateVariable, array $projectBasicVariable, array $runtimeVariable = [])
	{
		$this->packs = $packs;
		$this->templateVariable = $templateVariable;
		$this->projectBasicVariable = $projectBasicVariable;
		$this->commands = $this->renderedCommand($packs, $templateVariable);
		$this->externalVariable = $runtimeVariable;
	}

	public function getRenderedCommand()
	{
		return $this->renderedCommand($this->commands, $this->templateVariable);
	}

	public function renderedCommand(array $packs, array $templateVariable)
	{
		// Extract
		extract($this->projectBasicVariable, EXTR_OVERWRITE);
		extract($this->runtimeVariable, EXTR_OVERWRITE);
		extract($templateVariable, EXTR_OVERWRITE);  // Let Template overwrite Basic
		// Include
		$merge = [];
		foreach ($packs as $pack) {
			include_once __DIR__ . '/' . $pack . '.pack.php';
			if (!empty($command)) {
				$merge = array_merge($merge, $command);
			}
		}

		return $merge;
	}


}