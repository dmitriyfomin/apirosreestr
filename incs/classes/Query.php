<?php
/**
* APIRosReestr.ru
* @link https://apirosreestr.ru/
* @author Dmitry Fomin
*/

class Query implements IConnect
{
    
    /**
    * @Override 
    * public string send(string $url, array $req)
    * Метод отправляет запрос к API Росреестра
    * @param string $url - адрес запроса
    * @param array $req - массив с содержимым запроса
    * @return string - возвращает контент (объект json)
    */
    public function send(string $url, array $req = []): string
    {
        if (function_exists('curl_init')) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        #curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Token: ' . TOKEN,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "APIRosReestr/1.0");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$result = curl_exec($ch);
		curl_close($ch);
		if (empty($result)) {
			throw new \Exception('Ошибка! Не удаётся подключиться к API');
		}
		return $result;
	} else {
            die('Ошибка! Требуется расширение PHP-cURL');
        }
    }
}