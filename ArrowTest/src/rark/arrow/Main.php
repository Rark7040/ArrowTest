<?php

declare(strict_types = 1);

namespace rark\arrow;

use pocketmine\plugin\PluginBase;
use pocketmine\entity\Entity;
use rark\arrow\listener\EventListener;
use rark\arrow\entity\TestArrow;


final class Main extends PluginBase{

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents(EventListener::getInstance(), $this);
		Entity::registerEntity(TestArrow::class, false, ['plugin::test_arrow']);
	}
}