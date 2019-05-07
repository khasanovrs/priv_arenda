<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    public function init()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'app\components\actions\ErrorAction',
            ],
            'index' => [
                'class' => 'app\components\actions\IndexAction',
            ],
            /**
             * авторизация
             */
            'auth' => [
                'class' => 'app\components\actions\login\AuthAction',
            ],
            /**
             * Управление пользователями
             */
            'pass-reset' => [
                'class' => 'app\components\actions\login\PassRestAction',
            ],
            'change-user' => [
                'class' => 'app\components\actions\login\ChangeUserAction',
            ],
            /**
             * Управление клиентами
             */
            'add-ur-client' => [
                'class' => 'app\components\actions\client\AddUrClientAction',
            ],
            'change-ur-client' => [
                'class' => 'app\components\actions\client\ChangeUrClientAction',
            ],
            /**
             * Управление филиалами
             */
            'add-branch' => [
                'class' => 'app\components\actions\branch\AddBranchAction',
            ]
        ];
    }

    public function beforeAction($action)
    {
        // отключаем Csrf валидацию
        $this->enableCsrfValidation = false;

        Yii::info('Начало запроса', 'BeginRequest');

        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        if (!is_array($result) || !isset($result['status']) || !isset($result['msg'])) {
            Yii::error('Неверный результат выполнения!' . serialize($result), __METHOD__);
            $result = ['status' => 'ERROR', 'msg' => 'ERROR'];
        }

        Yii::info('Результат запроса: ' . serialize($result), 'EndRequest');

        return parent::afterAction($action, $result);
    }
}
