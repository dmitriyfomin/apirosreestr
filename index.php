<?php

/**
* APIRosReestr.ru
* @link https://apirosreestr.ru/
* @author Dmitry Fomin
*/

require 'incs/bootstrap.php';
#------------ View -------------#
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title>Получение информации об объекте по адресу или кадастровому номеру</title>
    </head>
    <body>
        <h2>Получение информации по адресу объекта</h2>
        Введите адрес объекта или кадастровый номер:<br/>
        <form method="post" action="/index.php?info=search">
        <input name="request" type="text"/><br/><br/>
        <input type="submit" value="Получить информацию"/>
        </form>
        <hr/>
        <h2>Получение полной информации по кадастровому номеру</h2>
        <form method="post" action="/index.php?info=infofull">
        Введите кадастровый номер:<br/>
        <input name="cadnumber" type="text"/>
        <input type="submit" value="Получить информацию"/>
        </form>
        <hr/>
        <h2>Информация из реестра объектов недвижимости</h2>
        <form method="post" action="/index.php?info=reestr">
        Введите кадастровый номер:<br/>
        <input name="cadnumber" type="text"/>
        <input type="submit" value="Получить информацию"/>
        </form>
        <br/><br/>
        <?php
        $info = htmlspecialchars(filter_input(INPUT_GET, 'info', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        switch ($info):
        #----- Поиск по введённому адресу -----#
        case 'search':
        $request = htmlspecialchars(filter_input(INPUT_POST, 'request'));
        echo (new Cadaster())->get_info_by_search($request, 0);
        break;
        
        #----- Поиск полной информации по кадастровому номеру -----#
        case 'infofull':
        $cadnumber = htmlspecialchars(filter_input(INPUT_POST, 'cadnumber'));
        if ((new Cadaster())->is_cadnumber($cadnumber)) {
            $fullinfo = (new Cadaster())->get_full_object_info($cadnumber);
            foreach ($fullinfo['EGRN'] as $obj => $val):
            if (! empty($val['CADNOMER'])) {
                echo 'Кадастровый номер: ' . $val['CADNOMER'] . '<br/>';
            }
            if (! empty($val['ADDRESS'])) {
                echo 'Адрес: ' . $val['ADDRESS'] . '<br/>';
            }
            if (! empty($val['TYPE'])) {
                echo 'Тип: ' . $val['TYPE'] . '<br/>';
            }
             if (! empty($val['AREA'])) {
                echo 'Площадь: ' . $val['AREA'] . '<br/>';
            }
             if (! empty($val['CATEGORY'])) {
                echo 'Категория: ' . $val['CATEGORY'] . '<br/>';
            }
            echo '<br/><br/>';
            if (! empty($val['Кадастровая стоимость'])) {
                echo 'Кадастровая стоимость: ' . $val['Кадастровая стоимость'] . '<br/>';
            }
            if (! empty($val['Дата определения стоимости'])) {
                echo 'Дата определения стоимости: ' . $val['Дата определения стоимости'] . '<br/>';
            }
            if (! empty($val['Дата внесения стоимости'])) {
                echo 'Дата внесения стоимости: ' . $val['Дата внесения стоимости'] . '<br/>';
            }
            if (! empty($val['Дата утверждения стоимости'])) {
                echo 'Дата утверждения стоимости: ' . $val['Дата утверждения стоимости'] . '<br/>';
            }
            if (! empty($val['Адрес (местоположение)'])) {
                echo 'Адрес (местоположение): ' . $val['Адрес (местоположение)'] . '<br/>';
            }
            if (! empty($val['Дата обновления информации'])) {
                echo 'Дата обновления информации: ' . $val['Дата обновления информации'] . '<br/>';
            }
            endforeach;
            echo '<form method="post" action="index.php?info=saveorder">';
            echo '<input type="hidden" name="_obj" value="' . (new Cadaster())->get_encoded_object($cadnumber) . '"/><br/>';
            echo $fullinfo['documents']['XZP']['label'] . ': ';
            echo $fullinfo['documents']['XZP']['available'] = ($fullinfo['documents']['XZP']['available'] == true) ? 'доступна. Добавить к заказу <input type="checkbox" name="xzp" value="yes" /><br/>' : 'отсутствует<br/>';
            if (! empty($fullinfo['documents']['XZP']['price'])) {
                echo 'Цена: ' . $fullinfo['documents']['XZP']['price'] . '<br/>';
            }
            echo $fullinfo['documents']['SOPP']['label'] . ': ';
            echo $fullinfo['documents']['SOPP']['available'] = ($fullinfo['documents']['SOPP']['available'] == true) ? 'доступна. Добавить к заказу <input type="checkbox" name="sopp" value="yes"/><br/>' : 'отсутствует<br/>';
            if (! empty($fullinfo['documents']['SOPP']['price'])) {
                echo 'Цена: ' . $fullinfo['documents']['SOPP']['price'] . '<br/>';
            }
            if (! empty($fullinfo['documents']['RSN'])) {
                if ($fullinfo['documents']['RSN']['available']) {
                    echo $fullinfo['documents']['RSN']['label'] . ': ';
                    echo $fullinfo['documents']['RSN']['available'] = ($fullinfo['documents']['RSN']['available'] == true) ? 'доступна. Добавить к заказу <input type="checkbox" name="rsn" value="yes"/><br/>' : 'отсутствует<br/>';
                    if ($fullinfo['documents']['RSN']['price'] != null) {
                        echo 'Цена: ' . $fullinfo['documents']['RSN']['price'] . '<br/>';
                    }
                }
            }
        echo '<input type="submit" value="Перейти к оформлению заказа"/></form>';
        } else {
            echo 'Кадастровый номер введён неверно!';
        }
        break;
        
        #----- Реестр объектов недвижимости -----#
        case 'reestr':
        $cadnumber = htmlspecialchars(filter_input(INPUT_POST, 'cadnumber'));
        if ((new Cadaster())->is_cadnumber($cadnumber)) {
            #print_r((new Cadaster())->get_reestr($cadnumber));
            $obj = (new Cadaster())->get_reestr($cadnumber);
            if (! empty($obj->reestr->apartments_residential->found)) {
            echo 'Найдено ' . $obj->reestr->apartments_residential->found . ' жилых помещений<br/><br/>';
            foreach ($obj->reestr->apartments_residential->objects as $val):
            if (! empty($val->CADNOMER)) {
                echo 'Кадастровый номер: ' . $val->CADNOMER . '<br/>';
            }
            if (! empty($val->ADDRESS)) {
                echo 'Адрес: ' . $val->ADDRESS . '<br/>';
            }
            if (! empty($val->TYPE)) {
                echo 'Тип: ' . $val->TYPE . '<br/>';
            }
             if (! empty($val->AREA)) {
                echo 'Площадь: ' . $val->AREA . '<br/>';
            }
            echo '<br/><br/>';
            endforeach;
            }
            echo '<br/><br/>';
            if (! empty($obj->reestr->apartments_nonresidential->found)) {
            echo 'Найдено ' . $obj->reestr->apartments_nonresidential->found . ' нежилых помещений<br/><br/>';
            foreach ($obj->reestr->apartments_nonresidential->objects as $val):
            if (! empty($val->CADNOMER)) {
                echo 'Кадастровый номер: ' . $val->CADNOMER . '<br/>';
            }
            if (! empty($val->ADDRESS)) {
                echo 'Адрес: ' . $val->ADDRESS . '<br/>';
            }
            if (! empty($val->TYPE)) {
                echo 'Тип: ' . $val->TYPE . '<br/>';
            }
             if (! empty($val->AREA)) {
                echo 'Площадь: ' . $val->AREA . '<br/>';
            }
            echo '<br/><br/>';
            endforeach;
            }
            echo '<br/><br/>';
            if (! empty($obj->reestr->lands->found)) {
            echo 'Найдено земельных участков ' . $obj->reestr->lands->found . '<br/><br/>';
            foreach ($obj->reestr->lands->objects as $val):
            if (! empty($val->CADNOMER)) {
                echo 'Кадастровый номер: ' . $val->CADNOMER . '<br/>';
            }
            if (! empty($val->ADDRESS)) {
                echo 'Адрес: ' . $val->ADDRESS . '<br/>';
            }
            if (! empty($val->TYPE)) {
                echo 'Тип: ' . $val->TYPE . '<br/>';
            }
             if (! empty($val->AREA)) {
                echo 'Площадь: ' . $val->AREA . '<br/>';
            }
            echo '<br/><br/>';
            endforeach;
            }
            echo '<br/><br/>';
            if (! empty($obj->reestr->buildings->found)) {
            echo 'Найдено строений ' . $obj->reestr->buildings->found . '<br/><br/>';
            foreach ($obj->reestr->buildings->objects as $val):
            if (! empty($val->CADNOMER)) {
                echo 'Кадастровый номер: ' . $val->CADNOMER . '<br/>';
            }
            if (! empty($val->ADDRESS)) {
                echo 'Адрес: ' . $val->ADDRESS . '<br/>';
            }
            if (! empty($val->TYPE)) {
                echo 'Тип: ' . $val->TYPE . '<br/>';
            }
             if (! empty($val->AREA)) {
                echo 'Площадь: ' . $val->AREA . '<br/>';
            }
            echo '<br/><br/>';
            endforeach;
            }
            echo '<br/><br/>';
            if (! empty($obj->reestr->constructions->found)) {
            echo 'Найдено ' . $obj->reestr->constructions->found . ' конструкций<br/><br/>';
            foreach ($obj->reestr->constructions->objects as $val):
            if (! empty($val->CADNOMER)) {
                echo 'Кадастровый номер: ' . $val->CADNOMER . '<br/>';
            }
            if (! empty($val->ADDRESS)) {
                echo 'Адрес: ' . $val->ADDRESS . '<br/>';
            }
            if (! empty($val->TYPE)) {
                echo 'Тип: ' . $val->TYPE . '<br/>';
            }
             if (! empty($val->AREA)) {
                echo 'Площадь: ' . $val->AREA . '<br/>';
            }
            echo '<br/><br/>';
            endforeach;
            }
            if (! empty($obj->reestr->others->found)) {
            echo 'Найдено прочих объектов ' . $obj->reestr->others->found . '<br/><br/>';
            foreach ($obj->reestr->constructions->objects as $val):
            if (! empty($val->CADNOMER)) {
                echo 'Кадастровый номер: ' . $val->CADNOMER . '<br/>';
            }
            if (! empty($val->ADDRESS)) {
                echo 'Адрес: ' . $val->ADDRESS . '<br/>';
            }
            if (! empty($val->TYPE)) {
                echo 'Тип: ' . $val->TYPE . '<br/>';
            }
             if (! empty($val->AREA)) {
                echo 'Площадь: ' . $val->AREA . '<br/>';
            }
            echo '<br/><br/>';
            endforeach;
            }
        } else {
            echo 'Кадастровый номер введён неверно!';
        }
        break;
        
        #----- Оформление заказа -----#
        case 'saveorder':
        $_obj = filter_input(INPUT_POST, '_obj');
        $xzp = filter_input(INPUT_POST, 'xzp');
        $sopp = filter_input(INPUT_POST, 'sopp');
        $rsn = filter_input(INPUT_POST, 'rsn');
        if ($xzp && $xzp == "yes")
        {
            $docs[] = "XZP";
        }
        if ($sopp && $sopp == "yes")
        {
            $docs[] = "SOPP";
        }
        if (sizeof($docs) > 0) {
            var_dump((new Cadaster())->request_two_orderings($_obj, join(', ', $docs)));
            //echo json_encode(["obj" => $_obj, "documents" => join(', ', $docs)]);
        } else {
            echo 'Ничего не выбрано для заказа!';
        }
        break;
        endswitch;
        ?>
    </body>
</html>
