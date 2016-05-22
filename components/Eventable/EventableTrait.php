<?php

namespace app\components\Eventable;

use Yii;
use app\components\Transport;
use app\models\EventHandler;
use yii\base\Behavior;

trait EventableTrait
{
	public function init() {
		$this->registerEvents();
	}

	public function registerEvents() {
		$events = self::getEvents();
		foreach($events as $event) {
			$class=(new \ReflectionClass(static::class))->getShortName();
			$events_handlers = EventHandler::findByEvent($class, $event);
			foreach ($events_handlers as $event_handler) {
				Yii::info('Register event:'.self::class.'::'.$event);
				$this->on($event, [$event_handler, 'fire_event']);
			}
		}
	}
}
