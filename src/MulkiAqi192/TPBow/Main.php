<?php

namespace MulkiAqi192\TPBow;

use MulkiAqi192\TPBow\GetBow;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->registerCommands();
	}

	private function registerCommands() {
		$this->getServer()->getCommandMap()->register("tpbow", new GetBow($this));
	}

}