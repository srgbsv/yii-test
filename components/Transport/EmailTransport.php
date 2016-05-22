<?php

namespace app\components;

use app\components\Transport\TransportableInterface;

class EmailTransport implements TransportableInterface{

	public function send($dst, $title, $message) {
		return Yii::$app->mailer->compose()
			->setTo($dst)
			->setFrom(['mail@rbnn.ru' => $this->name])
			->setSubject($title)
			->setHtmlBody($message)
			->send();
	}

}
