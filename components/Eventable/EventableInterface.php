<?php

namespace app\components\Eventable;

interface EventableInterface {
	public static function getEvents();

	public static function getRecipientList();

	public function getRecipient($name);
}
