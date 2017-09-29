<?php

/**
* APIRosReestr.ru
* @link https://apirosreestr.ru/
* @author Dmitry Fomin
*/

class Cadaster implements IOrder
{

    public function __construct()
    {
        $this->query = new Query();
    }
    
    /**
    * public resource download(int $doc_id, string $ext): void
    * Метод загрузки документа
    * @param int $doc_id - идентификатор документа
    * @param string $ext - расширение файла
    * @return resource
    */
    public function download(int $doc_id, string $ext): resource
    {
        return $this->query->send(RequestUrl::CADASTER_DOWNLOAD_URL, ["document_id" => $doc_id, "format" => $ext]);
    }
    
    /**
    * public void get_info_by_search(string $addr, int $is_grouped)
    * Метод обрабатывает полученный json-объект и выводит информацию поиска по адресу или кадастровому номеру
    * @param string $data - адрес, либо кадастровый номер из формы
    * @param int $is_grouped - группировать элементы. По умолч. 0
    * @return void - вывод информации
    */
    public function get_info_by_search(string $data, int $is_grouped = 0): void
    {
        $query = json_decode($this->query->send(RequestUrl::CADASTER_SEARCH_URL, ["query" => $data, "grouped" => $is_grouped]), true);
        if (sizeof($query['found']) > 0) {
        echo 'Найдено: ' . $query['found'] . '<br/><br/>';
        foreach($query['objects'] as $obj => $val):
        echo 'Кадастровый номер: ' . $val['CADNOMER'] . '<br/>';
        echo 'Адрес: ' . $val['ADDRESS'] . '<br/>';
        echo 'Тип: ' . $val['TYPE'] . '<br/>';
        if (! empty($val['AREA'])) {
            echo 'Площадь: ' . $val['AREA'] . '<br/>';
        }
        if (! empty($val['CATEGORY'])) {
            echo 'Категория: ' . $val['CATEGORY'] . '<br/>';
        }
        echo '<hr/><br/>';
        endforeach;
        } else {
            echo 'Ничего не найдено!';
        }
    }
    
    /**
    * public string get_encoded_object(string $cadnomer)
    * Метод получения уникального идентификатора объекта
    * @params string $cadnomer - кадастровый номер
    * @return string - Уникальный код для оформления заказа
    */
    public function get_encoded_object(string $cadnomer): string
    {
        return json_decode($this->query->send(RequestUrl::CADASTER_OBJECT_INFO_FULL_URL, ["query" => $cadnomer]), true)['encoded_object'];
    }
    
    /**
    * public array get_full_object_info(string $cadnomer)
    * Метод возвращает в виде массива полную информацию об объекте 
    * @param string $cadnomer - кадастровый номер из формы
    * @return array - Полная информация об объекте
    */
    public function get_full_object_info(string $cadnomer): array
    {
        return json_decode($this->query->send(RequestUrl::CADASTER_OBJECT_INFO_FULL_URL, ["query" => $cadnomer]), true);
    }
    
    /**
    * public array get_reestr(string $cadnomer)
    * Метод вывода реестра объектов невижимости, относящейся к дому по кадастровому номеру этого дома
    * @param string $cadnomer - кадастровый номер
    * @return array - Возвращает реестр объектов недвижимости, относящейся к дому по кадастровому номеру этого дома 
    */
    public function get_reestr(string $cadnomer): array
    {
        return json_decode($this->query->send(RequestUrl::CADASTER_REESTR_URL, ["query" => $cadnomer]), true);
    }
    
    /**
    * public bool is_cadnumber( void )
    * Метод валидации кадастрового номера
    * @param string $cadnomer - кадастровый номер
    * @return bool - Проверяет соответствует ли кадастровый номер стандарту
    */
    public function is_cadnumber(string $cadnomer): bool
    {
        if (preg_match("/(\d{2}:){2}(\d{6,}:){1}(\d{1,}){1}/", $cadnomer)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
    * @Override
    * public array get_all_home_owners(string $enc_object, array $docs)
    * Метод запроса двух выписок
    * @param string $enc_object - уникальный код объекта
    * @param string $docs - перечень заказываемых документов
    * @return array - Результат запроса
    */
    public function get_all_home_owners(string $enc_object, string $docs): array
    {
       return json_decode($this->query->send(RequestUrl::CADASTER_SAVE_ORDER_URL, ["encoded_object" => $enc_object, "documents" => $docs]), true);
    }
    
    /**
    * @Override
    * public array get_owners(string $enc_object, array $docs)
    * Метод запроса двух выписок
    * @param string $enc_object - уникальный код объекта
    * @param string $docs - перечень заказываемых документов
    * @return array - Результат запроса
    */
    public function get_owners(string $enc_object, string $docs): array
    {
       return json_decode($this->query->send(RequestUrl::CADASTER_SAVE_ORDER_URL, ["encoded_object" => $enc_object, "documents" => $docs]), true);
    }
    
    /**
    * @Override
    * public array request_two_orderings(string $enc_object, array $docs)
    * Метод запроса двух выписок
    * @param string $enc_object - уникальный код объекта
    * @param string $docs - перечень заказываемых документов
    * @return array - Результат запроса
    */
    public function request_two_orderings(string $enc_object, string $docs): array
    {
       return json_decode($this->query->send(RequestUrl::CADASTER_SAVE_ORDER_URL, ["encoded_object" => $enc_object, "documents" => [$docs]]), true);
    }
}