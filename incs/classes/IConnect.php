<?php
/**
* APIRosReestr.ru
* @link https://apirosreestr.ru/
* @author Dmitry Fomin
*/

interface IConnect
{
    
     /**
    * public string send(string $url, array $req)
    * Метод отправляет запрос к API Росреестра
    * @param string $url - адрес запроса
    * @param array $req - массив с содержимым запроса
    * @return string - возвращает контент (объект json)
    */
    public function send(string $url, array $req): string;
}