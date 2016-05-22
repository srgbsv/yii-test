<?php

namespace app\components\Transport;

use app\components\Transport\WebTransport;
use app\components\Transport\TransportableInterface;
use yii\base\Component;

class Transport extends Component {

	public static function getTransports() {
		return [
			'web',
			'email'
		];
	}

	private $transport_name;
	private $transport;

	public function __construct($transport_name = 'web') {
		$this->transport = null;
		if ($transport_name != 'web') {
			$transport = __NAMESPACE__ . $transport_name . 'Transport';
			if (class_exists($transport) && in_array("app\\components\\TransportableInterface", class_implements($transport))) {
				$this->transport = $transport;
			} else {
				$this->transport_name = $transport_name;
				$this->transport = new WebTransport();
			}
		} else {
			$this->transport_name = $transport_name;
			$this->transport = new WebTransport();
		}
	}

	public function send($recipients, $title, $msg) {
		if ($this->transport) {
			foreach($recipients as $recipient) {
				$this->transport->send($recipient->getDst($this->transport_name), $title, $msg);
			}
		}
	}
}
