<?php

declare(strict_types = 1);

namespace rark\arrow\listener;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityShootBowEvent;
use rark\arrow\entity\TestArrow;


final class EventListener implements Listener{

	private function __construct(){}

	public static function getInstance():self{
		static $self;
		return $self?? $self = new self;
	}

	public function onEntityShootBow(EntityShootBowEvent $event):void{
		$arrow = $event->getProjectile();
		$event->setProjectile(
			new TestArrow(
				$arrow->asPosition()->getLevel(),
				$arrow->namedtag,
				$event->getEntity()
			)
		);
	}
}