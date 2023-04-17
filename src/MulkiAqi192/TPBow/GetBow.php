<?php

namespace MulkiAqi192\TPBow;

use MulkiAqi192\TPBow\Main;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\Plugin;

class GetBow extends Command implements PluginOwned {

	/**@var Main $plugin */
	private $plugin;

	public function __construct(Main $plugin){
		parent::__construct("tpbow", "Get yourself a teleportation bow");
		$this->setPermission("tpbow.use");
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, String $commandLabel, array $args) : bool {

		if(!$sender instanceof Player){
			$sender->sendMessage("You can only use this command in-game!");
			return false;
		}
		$this->plugin->getBow($sender);
		$sender->sendMessage(TextFormat::GREEN . "You've achieve your Teleport Bow!");
		return true;
	}

	public function getOwningPlugin() : Main{
		return $this->plugin;
	}

}