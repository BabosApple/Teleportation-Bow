<?php
namespace MulkiAqi192\TPBow;

use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\entity\projectile\Arrow;
use pocketmine\math\Vector3;
use pocketmine\event\entity\{EntityShootBowEvent, ProjectileHitBlockEvent, ProjectileHitEntityEvent};
use pocketmine\scheduler\ClosureTask;
use pocketmine\world\particle\FlameParticle;

class EventListener implements Listener {

	private $player = [];

	public function onShoot(EntityShootBowEvent $event){
		$entity = $event->getEntity();
		$name = $entity->getName();
		$projectile = $event->getProjectile();
		$nbt = $event->getBow()->getNamedTag();
		if($nbt->getTag("tpbow")){
			if($nbt->getString("tpbow")){
				if(!isset($this->player[$name])){
					$this->player[$name] = ['entity' => $entity, 'arrows' => []];
				}
				$this->player[$name]['entity'] = $entity;
				$this->player[$name]['arrows'][] = $projectile;
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
			foreach($this->player as $player => $playerData){
				if(in_array($entity, $playerData['arrows'])){
					$index = array_search($entity, $playerData['arrows']);
					if($index !== false){
						unset($playerData['arrows'][$index]);
						$entity->setSilent(true);
						$entity->flagForDespawn();
						$playerData['entity']->teleport(new Vector3($x, $y, $z));
						break;
					}
				}
			}
		}
	}
	
	public function onHitProjectileEntity(ProjectileHitEntityEvent $event){
		$entity = $event->getEntity();
		$hit = $event->getEntityHit();
		if($entity instanceof Arrow){
			foreach($this->player as $player => $playerData){
				if(in_array($entity, $playerData['arrows'])){
					$index = array_search($entity, $playerData['arrows']);
					if($index !== false){
						if(!$playerData['entity']->getPosition()->distance($hit->getPosition()) <= 0){
							unset($playerData['arrows'][$index]);
							$playerData['entity']->teleport(new Vector3($hit->getPosition()->getX(), $hit->getPosition()->getY(), $hit->getPosition()->getZ()));
							break;
						}
					}
				}
			}
		}
	}
}
