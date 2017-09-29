<?php

/**
* APIRosReestr.ru
* @link https://apirosreestr.ru/
* @author Dmitry Fomin
*/

# Уникальный токен
const TOKEN = "";

# Установка автоподключения классов
spl_autoload_register(function ($class) {
   require_once 'classes/' . $class . '.php'; 
});
