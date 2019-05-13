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
                'class' => 'app\components\actions\auth\AuthAction',
            ],
            /**
             * Управление пользователями
             */
            'add-user' => [
                'class' => 'app\components\actions\login\AddUserAction',
            ],
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
            ],
            'change-branch' => [
                'class' => 'app\components\actions\branch\ChangeBranchAction',
            ],
            'delete-branch' => [
                'class' => 'app\components\actions\branch\DeleteBranchAction',
            ],
            /**
             * Управление статусами для юр.лиц
             */
            'add-ur-status' => [
                'class' => 'app\components\actions\statusUr\AddUrStatusAction',
            ],
            'delete-ur-status' => [
                'class' => 'app\components\actions\statusUr\DeleteUrStatusAction',
            ],
            /**
             * Управление источниками
             */
            'add-ur-source' => [
                'class' => 'app\components\actions\sourceUr\AddUrSourceAction',
            ],
            'delete-ur-source' => [
                'class' => 'app\components\actions\sourceUr\DeleteUrSourceAction',
            ],
            /**
             * Управление складами
             */
            'add-stock' => [
                'class' => 'app\components\actions\stock\AddStockAction',
            ],
            'delete-stock' => [
                'class' => 'app\components\actions\stock\DeleteStockAction',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'SessionFilter' => [
                'class' => 'app\components\filters\SessionFilter',
            ],
            'PrBlockFilter' => [
                'class' => 'app\components\filters\PrBlockFilter',
            ]
        ];
    }

    public function beforeAction($action)
    {
        // отключаем Csrf валидацию
        $this->enableCsrfValidation = false;

        Yii::info('Начало запроса', 'BeginRequest');

        $request = Yii::$app->request;
        $data = $request->getBodyParam('data');
        $request->setBodyParams($data);

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
