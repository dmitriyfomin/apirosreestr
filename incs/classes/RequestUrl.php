<?php

/**
* APIRosReestr.ru
* @link https://apirosreestr.ru/
* @author Dmitry Fomin
*/

abstract class RequestUrl
{
    
    /* Адрес поиска объектов */
    const CADASTER_SEARCH_URL = "https://apirosreestr.ru/api/cadaster/search";
    
    /* Адрес поиска по кадастровому номеру */
    const CADASTER_OBJECT_INFO_FULL_URL = "https://apirosreestr.ru/api/cadaster/objectInfoFull";
    
    /* Адрес реестра объектов недвижимости */
    const CADASTER_REESTR_URL = "https://apirosreestr.ru/api/cadaster/reestr";
    
    /* Адрес оформления заказа */
    const CADASTER_SAVE_ORDER_URL = "https://apirosreestr.ru/api/cadaster/save_order";
    
    /* Адрес информации о транзакции */
    const TRANSACTION_INFO_URL = "https://apirosreestr.ru/api/transaction/info";
    
    /* Адрес подтверждения оплаты */
    const TRANSACTION_PAY_URL = "https://apirosreestr.ru/api/transaction/pay";
    
    /* Адрес информации о заказе */
    const CADASTER_ORDERS_URL = "https://apirosreestr.ru/api/cadaster/orders";
    
    /* Адрес загрузки документа */
    const CADASTER_DOWNLOAD_URL = "https://apirosreestr.ru/api/cadaster/download";
}