<?php
/**
 * Интеграция с приставами
 */

namespace app\components\integration;

use app\models\Clients;
use Yii;

class BailiffsClass
{
    /**
     * Функция получения информации по клиенту через сервис приставов
     * @param $id_client
     * @return array
     */
    public static function getData($id_client)
    {
        Yii::info('Запуск функции getData', __METHOD__);
        $result = [];
        $params = '';

        if ($id_client === '') {
            Yii::error('Не передан идентификатор клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор клиента'
            ];
        }

        /**
         * @var Clients $client
         */
        $client = Clients::find()->where('id=:id', [':id' => $id_client])->one();

        if (!is_object($client)) {
            Yii::error('Ошибка при поиске клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при поиске клиента'
            ];
        }

        if ($client->type === 1) {
            $fio = explode(" ", $client->name);
            $clientParam = [
                'token' => 'zC9MhiUcVmiA',
                'region' => $client->branch->region,
                'firstname' => $fio[1],
                'lastname' => $fio[0],
            ];
        } else {
            $clientParam = [
                'token' => 'zC9MhiUcVmiA',
                'region' => $client->branch->region,
                'name' => $client->name,
            ];
        }


        foreach ($clientParam as $key => $value) {
            $params .= $key . '=' . $value . '&';
        }

        $params = trim($params, '&');

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, "https://api-ip.fssprus.ru/api/v1.0/search/physical?" . $params);
        curl_setopt($c, CURLOPT_PROXY, 'http://192.168.5.12:3140');
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $src = curl_exec($c);
        curl_close($c);

        Yii::info('Получили данные:' . serialize($src), __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Клоиент успешно проверен',
            'data' => $result
        ];
    }
}