<?php

namespace app\controllers;

use app\components\Session\Sessions;
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
            'get-users' => [
                'class' => 'app\components\actions\users\GetUserAction',
            ],
            'add-users' => [
                'class' => 'app\components\actions\users\AddUserAction',
            ],
            'pass-reset' => [
                'class' => 'app\components\actions\users\PassRestAction',
            ],
            'change-user' => [
                'class' => 'app\components\actions\users\ChangeUserAction',
            ],
            /**
             * Управление клиентами
             */
            'get-client' => [
                'class' => 'app\components\actions\client\GetUrClientAction',
            ],
            'add-client' => [
                'class' => 'app\components\actions\client\AddUrClientAction',
            ],
            'get-client-info' => [
                'class' => 'app\components\actions\client\GetClientInfoAction',
            ],
            'update-client-info' => [
                'class' => 'app\components\actions\client\UpdateClientInfoAction',
            ],
            'get-client-fields' => [
                'class' => 'app\components\actions\client\GetFieldsClientAction',
            ],
            'change-client-fields' => [
                'class' => 'app\components\actions\client\ChangeFieldsClientAction',
            ],
            'update-status-client' => [
                'class' => 'app\components\actions\client\UpdateStatusUrClientAction',
            ],
            /**
             * Управление филиалами
             */
            'get-branch' => [
                'class' => 'app\components\actions\branch\GetBranchAction',
            ],
            /**
             * Управление статусами для клиентов
             */
            'get-status' => [
                'class' => 'app\components\actions\status\GetStatusAction',
            ],
            /**
             * Управление источниками
             */
            'get-source' => [
                'class' => 'app\components\actions\params\GetSourceAction',
            ],
            /**
             * Управление складами
             */
            'get-stock' => [
                'class' => 'app\components\actions\stock\GetStockAction',
            ],
            /**
             * Управление ролями
             */
            'get-roles' => [
                'class' => 'app\components\actions\roles\GetRolesAction',
            ],
            /**
             * Управление правами
             */
            'get-rights' => [
                'class' => 'app\components\actions\rights\GetRightsAction',
            ],
            /**
             * Управление скидками
             */
            'get-discount' => [
                'class' => 'app\components\actions\discount\GetDiscountAction',
            ],
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

        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        if (!is_array($result) || !isset($result['status']) || !isset($result['msg'])) {
            Yii::error('Неверный результат выполнения!' . serialize($result), __METHOD__);
            $result = ['status' => 'ERROR', 'msg' => 'ERROR'];
        }

        /**
         * @var Sessions $Sessions
         */
        try {
            $Sessions = Yii::$app->get('Sessions');
        } catch (\Exception $e) {
            Yii::error('Не смогли найти компонент MibSession: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        $session = $Sessions->getSession();

        Yii::info('Результат запроса: ' . serialize($session), 'EndRequest');

        //$result['session_id'] = $session->session_id;

        if (isset($result['data'])) {
            $result['data'] = json_encode($result['data']);
            $result['data'] = base64_encode($result['data']);
        }

        Yii::info('Результат запроса: ' . serialize($result), 'EndRequest');

        return parent::afterAction($action, $result);
    }
}
