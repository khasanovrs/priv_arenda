<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class SsController extends Controller
{
    /**
     * Проверка состояний
     * @return bool
     */
    public function actionIndex()
    {
        Yii::info('Запуск функции actionIndex', __METHOD__);

        $aContext = array(
            'https' => array(
                'proxy' => 'http://192.168.5.12:3140',
                'request_fulluri' => true
            ),
        );

        $cxContext = stream_context_create($aContext);

        $key = '495cb053-42e7-4907-8996-933db82600d0';

        $info = file_get_contents('https://api.rasp.yandex.net/v3.0/stations_list/?apikey=' . $key . '&lang=ru_RU&format=json', false, $cxContext);
        $info = json_decode($info, true);
        print_r($info);

        return true;
    }
}
