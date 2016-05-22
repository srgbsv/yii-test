<?php

namespace app\components\Transport;

/**
 * Класс-email транспорта. Используется для отсылки уведомлений по почте
 *
 * @author Sergey Bosov <srg.bsv@gmail.com>
 *
 */

use Yii;
use app\components\Transport\TransportableInterface;

class EmailTransport implements TransportableInterface{

	/**
	 * Функция отправки сообщения через E-mail
	 *
	 * @param $dst - E-mail адрес получателя
	 * @param $title - Заголовок сообщения (сейчас не используется)
	 * @param $message - Сообщение
	 * @return bool
	 */
	public function send($dst, $title, $message) {
		return Yii::$app->mailer->compose()
			->setTo($dst)
			->setFrom(['mail@rbnn.ru' => 'Тестовый сайт'])
			->setSubject($title)
			->setHtmlBody($message)
			->send();
	}

}
