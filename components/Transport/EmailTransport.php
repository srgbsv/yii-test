<?php

namespace app\components\Transport;

use Yii;
use app\components\Transport\TransportableInterface;

class EmailTransport implements TransportableInterface{

	public function send($dst, $title, $message) {
		return Yii::$app->mailer->compose()
			->setTo($dst)
			->setFrom(['mail@rbnn.ru' => 'Тестовый сайт'])
			->setSubject($title)
			->setHtmlBody($message)
			->send();
	}

}
