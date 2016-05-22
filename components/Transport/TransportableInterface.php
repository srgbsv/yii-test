<?php

namespace app\components\Transport;

/**
 * Интерфейс, который должен быть имплементирован классом-сервисом отправки уведомлений
 *
 * @author Sergey Bosov <srg.bsv@gmail.com>
 *
 */

interface TransportableInterface {
	public function send($dst, $title, $content);
}
