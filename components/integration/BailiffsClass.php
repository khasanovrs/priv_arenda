<?php
/**
 * Интеграция с приставами
 */

namespace app\components\integration;

use app\models\Branch;
use app\models\Clients;
use Yii;
use linslin\yii2\curl;

class BailiffsClass
{
    /**
     * Функция получения информации по клиенту через сервис приставов
     * @param $fio
     * @param $branch
     * @param $type
     * @return array
     */
    public static function getData($fio, $branch, $type)
    {
        Yii::info('Запуск функции getData', __METHOD__);
        $result = [];

        if ($fio === '') {
            Yii::error('Не передан фио клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан фио клиента'
            ];
        }

        if ($branch === '') {
            Yii::error('Не передан регион клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан регион клиента'
            ];
        }

        if ($type === '') {
            Yii::error('Не передан тип клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан тип клиента'
            ];
        }

        /**
         * @var Branch $current_branch
         */
        $current_branch = Branch::find()->where('id=:id', [':id' => $branch])->one();

        if (!is_object($current_branch)) {
            Yii::error('Ошибка при поиске филиала', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при поиске филиала'
            ];
        }

        if ($type === 1) {
            $fio = explode(" ", $fio);
            $clientParam = [
                'token' => 'zC9MhiUcVmiA',
                'region' => $current_branch->region,
                'firstname' => $fio[1],
                'lastname' => $fio[0],
            ];
        } else {
            $clientParam = [
                'token' => 'zC9MhiUcVmiA',
                'region' => $current_branch->region,
                'name' => $fio,
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

        if (!is_object($ll) || !isset($ll->status) || $ll->status !== 'success') {
            Yii::error('Поймали Exception при проверке клиента у приставов: ' . serialize($ll), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => ' Ошибка при проверке клиента у приставов',
                'data' => $result
            ];
        }

        if (is_object($ll) && isset($ll->status) && $ll->status === 'success' && is_object($ll->response) && isset($ll->response->task)) {
            Yii::info('У клиента есть долги:' . serialize($ll->response->task), __METHOD__);

            try {
                $curl = new curl\Curl();
                $response = $curl->setGetParams(['token' => 'zC9MhiUcVmiA', 'task' => $ll->response->task])->get('https://api-ip.fssprus.ru/api/v1.0/result');
                $resultDolg = json_decode($response);
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при проверке клиента у приставов: ' . serialize($e->getMessage()), __METHOD__);
                return [
                    'status' => 'ERROR',
                    'msg' => ' Ошибка при проверке клиента у приставов',
                    'data' => $result
                ];
            }

            Yii::info('Получили данные:' . serialize($resultDolg), __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Клиент успешно проверен',
                'data' => [$ll->response->task]
            ];
        } else {
            Yii::info('Клиент проверен', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Клиент успешно проверен',
                'data' => $result
            ];
        }
    }
}