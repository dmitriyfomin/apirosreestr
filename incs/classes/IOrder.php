<?php

/**
* APIRosReestr.ru
* @link https://apirosreestr.ru/
* @author Dmitry Fomin
*/

interface IOrder
{
    
    /**
    * public array get_all_home_owners(string $enc_object, array $docs)
    * Метод запроса двух выписок
    * @param string $enc_object - Уникальный код объекта
    * @param string $docs - Перечень заказываемых документов
    * @return array - Результат запроса
    */
    public function get_all_home_owners(string $enc_object, string $docs): array;
    
    /**
    * public array get_owners(string $enc_object, array $docs)
    * Метод запроса двух выписок
    * @param string $enc_object - Уникальный код объекта
    * @param string $docs - Перечень заказываемых документов
    * @return array - Результат запроса
    */
    public function get_owners(string $enc_object, string $docs): array;
    
    /**
    * public array request_two_orderings(string $enc_object, array $docs)
    * Метод запроса двух выписок
    * @param string $enc_object - Уникальный код объекта
    * @param string $docs - Перечень заказываемых документов
    * @return array - Результат запроса
    */
    public function request_two_orderings(string $enc_object, string $docs): array;
}