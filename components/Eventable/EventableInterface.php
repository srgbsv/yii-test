<?php

namespace app\components\Eventable;

/**
 * Интерфейс, который должны имплементировать все модели, которые будут использовать события
 *
 * @author Sergey Bosov <srg.bsv@gmail.com>
 *
 */

interface EventableInterface {

	/**
	* Возвращает массив поддерживаемых событий
	* @return array
	*/
	public static function getEvents();

	/**
	 * Возвращает массив возможных получателей моделей
	 *
	 * @return array
	 */
	public static function getRecipientList();

	/**
	 *
	 * Возвращает получателя по имени.
	 *
	 * @param $name - строка имя получателя из RecipientList
	 * @return mixed Экземпляр класса, который имплементирует RecipientInterface
	 */
	public function getRecipient($name);
}
