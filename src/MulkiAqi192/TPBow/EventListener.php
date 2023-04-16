<?php

namespace MulkiAqi192\TPBow;

use MulkiAqi192\TPBow\Main;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\entity\projectile\Arrow;
use pocketmine\math\Vector3;
use pocketmine\event\entity\{EntityShootBowEvent, ProjectileHitBlockEvent, ProjectileHitEntityEvent};

class EventListener implements Listener {

	public $player;
	private $plugin;
	private bool $projectile;

	public function __construct(Main $plugin){
		$this->plugin = $plugin;
	}

	public function onShoot(EntityShootBowEvent $event){
		$this->plugin->getLogger()->info("Projectile launched");
		$entity = $event->getEntity();
		$projectile = $event->getProjectile();
		$nbt = $event->getBow()->getNamedTag();
		if($nbt->getTag("tpbow")){
			if($nbt->getString("tpbow")){
				$this->player = $entity;
				$this->projectile = true;
			}
		}
	}

	public function onHitProjectileBlock(ProjectileHitBlockEvent $event){
		$entity = $event->getEntity();
		$block = $event->getBlockHit();
		$x = $entity->getPosition()->getX();
		$y = $entity->getPosition()->getY();
		$z = $entity->getPosition()->getZ();
		if($entity instanceof Arrow){
			if(isset($this->projectile)){
				if($this->projectile === true){
					$this->player->teleport(new Vector3($x, $y, $z));
         			$entity->close();
         			$this->projectile = false;
				}
			}
		}
	}

	public function onHitProjectileEntity(ProjectileHitEntityEvent $event){
		$entity = $event->getEntity();
		$hit = $event->getEntityHit();
		if($entity instanceof Arrow){
			if(isset($this->projectile)){
				if($this->projectile === true){
					$this->player->teleport(new Vector3($hit->getPosition()->getX(), $hit->getPosition()->getY(), $hit->getPosition()->getZ()));
					$this->projectile = false;
				}
			}
		}
	}

}
