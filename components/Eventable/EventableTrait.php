<?php

namespace app\components\Eventable;

/**
 * Поведение, которое должна использовать моделять, использующая события
 *
 * @author Sergey Bosov <srg.bsv@gmail.com>
 *
 */

use Yii;
use app\components\Transport;
use app\models\EventHandler;

trait EventableTrait
{
	public function init() {
		parent::init();
		$this->registerEvents();
	}

	/**
	 * Функция запускается при инициализации объекта и регистрирует все события, которые
	 * есть в БД для данной модели
	 *
	 * @return mixed
	 */
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
