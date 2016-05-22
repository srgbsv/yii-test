<?php

namespace app\components\Transport;

/**
 * Интерфейс, который должен имплементировать класс,
 * являющийся получателем нотификаци.
 *
 * @author Sergey Bosov <srg.bsv@gmail.com>
 *
 */

interface RecipientInterface {

	/**
	 * Идентификатор для транспорта, например id пользователя для Web нотификаций,
	 * email для e-mail, id в телеграмм если нужно будет для транспорта телеграмм.
	 *
	 * @param $name - строка имя получателя из RecipientList
	 * @return string id транспорта
	 */
	public function getDst($name);
}
