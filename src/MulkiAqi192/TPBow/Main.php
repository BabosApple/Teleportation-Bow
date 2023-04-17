<?php

namespace MulkiAqi192\TPBow;

use MulkiAqi192\TPBow\GetBow;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\StringTag;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->registerCommands();
	}

	private function registerCommands() {
		$this->getServer()->getCommandMap()->register("TPBow", new GetBow($this));
	}

	public function getBow(Player $player, String $name = TextFormat::AQUA . "Teleportation Bow"){
		$bow = VanillaItems::BOW();
		$nbt = $bow->getNamedTag();
		$nbt->setTag("tpbow", new StringTag("tpbowstring"));
		$bow->setNamedTag($nbt);
		$bow->setCustomName($name);
		$player->getInventory()->addItem($bow);
		return;
	}

}
