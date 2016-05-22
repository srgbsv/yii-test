<?php

namespace app\components\Transport;

/**
 * Сервис локатор для транспортов, используется для предоставления
 * сервисов для отсылки нотификаци
 *
 * @author Sergey Bosov <srg.bsv@gmail.com>
 *
 */

use app\components\Transport\WebTransport;
use app\components\Transport\TransportableInterface;
use yii\base\Component;



class Transport extends Component {

	/**
	 * Возвращает список возможных сервисов
	 *
	 * @return array
	 */

	public static function getTransports() {
		return [
			'web',
			'email'
		];
	}

	private $transport_name;
	private $transport;

	/**
	 * Проверяет есть ли выбранный сервис, если нет то используется по умолчанию Web
	 *
	 * @return array
	 */
	public function __construct($transport_name = 'web') {
		$this->transport = null;
		if ($transport_name != 'web') {
			$transport = __NAMESPACE__ ."\\". ucfirst($transport_name) . 'Transport';
			if (class_exists($transport) && in_array("app\\components\\Transport\\TransportableInterface", class_implements($transport))) {
				$this->transport = new $transport;
				$this->transport_name = $transport_name;
			} else {
				$this->transport_name = $transport_name;
				$this->transport = new WebTransport();
			}
		} else {
			$this->transport_name = $transport_name;
			$this->transport = new WebTransport();
		}
	}

	/**
	 * Отсылает уведомление используя сервис
	 *
	 * @return array
	 */
	public function send($recipients, $title, $msg) {
		if ($this->transport) {
			foreach($recipients as $recipient) {
				$this->transport->send($recipient->getDst($this->transport_name), $title, $msg);
			}
		}
	}
}
