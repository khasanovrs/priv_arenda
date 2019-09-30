<?php
/**
 * Интеграция с приставами
 */

namespace app\components\integration;

use app\models\Clients;
use Yii;
use linslin\yii2\curl;

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

        try {
            $curl = new curl\Curl();
            $response = $curl->setGetParams($clientParam)->get('https://api-ip.fssprus.ru/api/v1.0/search/physical');
            $ll = json_decode($response);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при проверке клиента у приставов: ' . serialize($e->getMessage()), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => ' Ошибка при проверке клиента у приставов',
                'data' => $result
            ];
        }

        Yii::info('Получили данные:' . serialize($ll), __METHOD__);

        if (is_object($ll) && isset($ll->status) && $ll->status === 'success') {
            return [
                'status' => 'SUCCESS',
                'msg' => 'Клиент успешно проверен',
                'data' => $result
            ];
        }
    }
}