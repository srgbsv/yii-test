<?php

namespace app\components\Transport;

use app\components\Transport\TransportableInterface;
use app\models\Notification;

class WebTransport implements TransportableInterface{

	public function send($dst, $title, $message) {
		$notification = new Notification();
		$notification->user_id = $dst;
		$notification->title = $title;
		$notification->content = $message;
		$notification->status = Notification::STATUS_UNREAD;
		$notification->save();
	}

}
