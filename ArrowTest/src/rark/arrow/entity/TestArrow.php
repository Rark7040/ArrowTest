<?php

declare(strict_types = 1);

namespace rark\arrow\entity;

use pocketmine\entity\projectile\Arrow;
use pocketmine\entity\{
	Entity,
	Living
};
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\math\RayTraceResult;


final class TestArrow extends Arrow{

	protected $gravity = 0;  //重力
	private $shooter;

	public function __construct(Level $level, CompoundTag $nbt, ?Entity $entity = null, bool $critical = false){
		parent::__construct(
			$level,
			$nbt,
			$entity,
			$critical
		);
		if($entity === null) return;
		$this->setMotion($entity->getDirectionVector()->normalize()->multiply(10)); //速度 この値を基本速度に掛け算してます
		$this->shooter = $entity;
	}

	public function entityBaseTick(int $tick = 1):bool{
		foreach($this->level->getEntities() as $entity){
			if(
				!$entity instanceof Living
					or
				$this->shooter === null
					or
				$this->shooter->getId() === $entity->getId() //当たり判定を大きくしすぎると打った人に当たるのでそれの防止
					or
				$this->distance($entity) > 10 //当たり判定
					or
				($bb = $entity->getBoundingBox()) === null //エンティティが当たり判定を持っているか
			) continue;

			$this->onHitEntity(
				$entity,
				new RayTraceResult(
					$bb,
					$this->getDirection(), //ここ間違ってるかも... ごめん...
					$entity
				)
			);
		}
		return parent::entityBaseTick($tick);
	}
}