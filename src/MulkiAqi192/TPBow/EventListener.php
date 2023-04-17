<?php
namespace MulkiAqi192\TPBow;
use MulkiAqi192\TPBow\Main;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\entity\projectile\Arrow;
use pocketmine\math\Vector3;
use pocketmine\event\entity\{EntityShootBowEvent, ProjectileHitBlockEvent, ProjectileHitEntityEvent};

class EventListener implements Listener {

	private $arrow = [];
	private $player;

	public function onShoot(EntityShootBowEvent $event){
		$entity = $event->getEntity();
		$projectile = $event->getProjectile();
		$nbt = $event->getBow()->getNamedTag();
		if($nbt->getTag("tpbow")){
			if($nbt->getString("tpbow")){
				$this->player = $entity;
				$this->arrow[$projectile->getNameTag()] = $projectile->getNameTag();
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
			if(isset($this->arrow[$entity->getNameTag()])){
				unset($this->arrow[$entity->getNameTag()]);
				$this->player->teleport(new Vector3($x, $y, $z));
         		$entity->close();
			}
		}
	}
	public function onHitProjectileEntity(ProjectileHitEntityEvent $event){
		$entity = $event->getEntity();
		$hit = $event->getEntityHit();
		if($entity instanceof Arrow){
			if(isset($this->arrow[$entity->getNameTag()])){
				unset($this->arrow[$entity->getNameTag()]);
				$this->player->teleport(new Vector3($hit->getPosition()->getX(), $hit->getPosition()->getY(), $hit->getPosition()->getZ()));
			}
		}
	}
}