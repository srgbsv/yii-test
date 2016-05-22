<?php

namespace app\components\Transport;

interface TransportableInterface {
	public function send($dst, $title, $content);
}
