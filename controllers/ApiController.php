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
            'exit' => [
                'class' => 'app\components\actions\auth\ExitAction',
            ],
            'get-main-info' => [
                'class' => 'app\components\actions\main\GetInfoAction',
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
            'get-search-client' => [
                'class' => 'app\components\actions\client\GetSearchClientAction',
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
             * Управление статусами для клиентов
             */
            'get-client-status' => [
                'class' => 'app\components\actions\status\GetStatusAction',
            ],
            'add-client-status' => [
                'class' => 'app\components\actions\status\AddStatusAction',
            ],
            'delete-client-status' => [
                'class' => 'app\components\actions\status\DeleteStatusAction',
            ],
            /**
             * Управление филиалами
             */
            'get-branch' => [
                'class' => 'app\components\actions\branch\GetBranchAction',
            ],
            'add-branch' => [
                'class' => 'app\components\actions\branch\AddBranchAction',
            ],
            'delete-branch' => [
                'class' => 'app\components\actions\branch\DeleteBranchAction',
            ],
            /**
             * Управление источниками
             */
            'get-source' => [
                'class' => 'app\components\actions\source\GetSourceAction',
            ],
            'add-source' => [
                'class' => 'app\components\actions\source\AddSourceAction',
            ],
            'delete-source' => [
                'class' => 'app\components\actions\source\DeleteSourceAction',
            ],
            /**
             * Управление складами
             */
            'get-stock' => [
                'class' => 'app\components\actions\stock\GetStockAction',
            ],
            'add-stock' => [
                'class' => 'app\components\actions\stock\AddStockAction',
            ],
            'delete-stock' => [
                'class' => 'app\components\actions\stock\DeleteStockAction',
            ],
            /**
             * Управление ролями
             */
            'get-roles' => [
                'class' => 'app\components\actions\roles\GetRolesAction',
            ],
            'add-roles' => [
                'class' => 'app\components\actions\roles\AddRolesAction',
            ],
            'delete-roles' => [
                'class' => 'app\components\actions\roles\DeleteRolesAction',
            ],
            /**
             * Управление правами
             */
            'get-rights' => [
                'class' => 'app\components\actions\rights\GetRightsAction',
            ],
            'add-rights' => [
                'class' => 'app\components\actions\rights\AddRightAction',
            ],
            'delete-rights' => [
                'class' => 'app\components\actions\rights\DeleteRightAction',
            ],
            /**
             * Управление скидками
             */
            'get-discount' => [
                'class' => 'app\components\actions\discount\GetDiscountAction',
            ],
            'add-discount' => [
                'class' => 'app\components\actions\discount\AddDiscountAction',
            ],
            'delete-discount' => [
                'class' => 'app\components\actions\discount\DeleteDiscountAction',
            ],
            /**
             * Управление оборудованиями
             */
            'get-equipments-type' => [
                'class' => 'app\components\actions\equipments\GetEquipmentTypeAction',
            ],
            'add-equipments-type' => [
                'class' => 'app\components\actions\equipments\AddEquipmentTypeAction',
            ],
            'delete-equipments-type' => [
                'class' => 'app\components\actions\equipments\DeleteEquipmentTypeAction',
            ],
            'get-equipments-category' => [
                'class' => 'app\components\actions\equipments\GetEquipmentCategoryAction',
            ],
            'add-equipments-category' => [
                'class' => 'app\components\actions\equipments\AddEquipmentCategoryAction',
            ],
            'delete-equipments-category' => [
                'class' => 'app\components\actions\equipments\DeleteEquipmentCategoryAction',
            ],
            'get-equipments-status' => [
                'class' => 'app\components\actions\equipments\GetEquipmentStatusAction',
            ],
            'get-equipments' => [
                'class' => 'app\components\actions\equipments\GetEquipmentAction',
            ],
            'get-equipments-search' => [
                'class' => 'app\components\actions\equipments\GetEquipmentSearchAction',
            ],
            'get-all-equipments-branch' => [
                'class' => 'app\components\actions\equipments\GetAllEquipmentBranchAction',
            ],
            'get-equipments-fields' => [
                'class' => 'app\components\actions\equipments\GetEquipmentActionFields',
            ],
            'change-equipments-fields' => [
                'class' => 'app\components\actions\equipments\ChangeEquipmentActionFields',
            ],
            'get-equipments-update-status' => [
                'class' => 'app\components\actions\equipments\GetEquipmentUpdateStatusAction',
            ],
            'add-equipment' => [
                'class' => 'app\components\actions\equipments\AddEquipmentAction',
            ],
            'add-equipment-photo' => [
                'class' => 'app\components\actions\equipments\AddEquipmentPhotoAction',
            ],
            'get-equipment-mark' => [
                'class' => 'app\components\actions\equipments\GetEquipmentMarkAction',
            ],
            'add-equipments-mark' => [
                'class' => 'app\components\actions\equipments\AddEquipmentMarkAction',
            ],
            'delete-equipments-mark' => [
                'class' => 'app\components\actions\equipments\DeleteEquipmentMarkAction',
            ],
            'get-equipments-info' => [
                'class' => 'app\components\actions\equipments\GetEquipmentInfoAction',
            ],
            'equipments-update' => [
                'class' => 'app\components\actions\equipments\EquipmentUpdateAction',
            ],
            'add-equipment-status' => [
                'class' => 'app\components\actions\equipments\AddEquipmentStatusAction',
            ],
            'delete-equipment-status' => [
                'class' => 'app\components\actions\equipments\DeleteEquipmentStatusAction',
            ],
            /**
             * Управление заявками
             */
            'get-applications-status' => [
                'class' => 'app\components\actions\applications\GetApplicationsStatusAction',
            ],
            'add-applications-status' => [
                'class' => 'app\components\actions\applications\AddApplicationsStatusAction',
            ],
            'delete-applications-status' => [
                'class' => 'app\components\actions\applications\DeleteApplicationsStatusAction',
            ],
            'update-applications-status' => [
                'class' => 'app\components\actions\applications\UpdateApplicationsStatusAction',
            ],
            'get-applications-type-lease' => [
                'class' => 'app\components\actions\applications\GetApplicationsTypeLeaseAction',
            ],
            'get-applications-delivery' => [
                'class' => 'app\components\actions\applications\GetApplicationsDeliveryAction',
            ],
            'get-applications-field' => [
                'class' => 'app\components\actions\applications\GetApplicationsFieldAction',
            ],
            'change-applications-field' => [
                'class' => 'app\components\actions\applications\ChangeApplicationsFieldAction',
            ],
            'get-applications' => [
                'class' => 'app\components\actions\applications\GetApplicationsAction',
            ],
            'get-application-info' => [
                'class' => 'app\components\actions\applications\GetApplicationInfoAction',
            ],
            'add-application' => [
                'class' => 'app\components\actions\applications\AddApplicationAction',
            ],
            /**
             * Управление финансами
             */
            'get-finance-fields' => [
                'class' => 'app\components\actions\finance\GetFinanceFieldAction',
            ],
            'change-finance-field' => [
                'class' => 'app\components\actions\finance\ChangeFinanceFieldAction',
            ],
            'get-finance-category' => [
                'class' => 'app\components\actions\finance\GetFinanceCategoryAction',
            ],
            'add-finance-category' => [
                'class' => 'app\components\actions\finance\AddFinanceCategoryAction',
            ],
            'delete-finance-category' => [
                'class' => 'app\components\actions\finance\DeleteFinanceCategoryAction',
            ],
            'get-finance-type' => [
                'class' => 'app\components\actions\finance\GetFinanceTypeAction',
            ],
            'get-finance' => [
                'class' => 'app\components\actions\finance\GetFinanceAction',
            ],
            'get-finance-info' => [
                'class' => 'app\components\actions\finance\GetFinanceInfoAction',
            ],
            'update-category-finance' => [
                'class' => 'app\components\actions\finance\UpdateFinanceCategoryAction',
            ],
            'add-finance' => [
                'class' => 'app\components\actions\finance\AddFinanceAction',
            ],
            /**
             * Управление кассой
             */
            'add-cashBox' => [
                'class' => 'app\components\actions\cashBox\AddCashBoxAction',
            ],
            'get-cashBox' => [
                'class' => 'app\components\actions\cashBox\GetCashBoxAction',
            ],
            'delete-cashBox' => [
                'class' => 'app\components\actions\cashBox\DeleteCashBoxAction',
            ],
            /**
             * Управление прокатом
             */
            'get-hire-field' => [
                'class' => 'app\components\actions\hire\GetHireFieldAction',
            ],
            'change-hire-field' => [
                'class' => 'app\components\actions\hire\ChangeHireFieldAction',
            ],
            'get-hire-status' => [
                'class' => 'app\components\actions\hire\GetHireStatusAction',
            ],
            'update-hire-status' => [
                'class' => 'app\components\actions\hire\UpdateHireStatusAction',
            ],
            'add-hire-status' => [
                'class' => 'app\components\actions\hire\AddHireStatusAction',
            ],
            'get-hire' => [
                'class' => 'app\components\actions\hire\GetHireAction',
            ],
            'get-hire-info' => [
                'class' => 'app\components\actions\hire\GetHireInfoAction',
            ],
            'update-hire' => [
                'class' => 'app\components\actions\hire\UpdateHireAction',
            ],
            /**
             * Работа с отчетами
             */
            'get-report-equipment' => [
                'class' => 'app\components\actions\report\GetReportEquipmentAction',
            ],
            'get-report-mini-block' => [
                'class' => 'app\components\actions\report\GetReportMiniBlockAction',
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

        if (isset($session->session_id)) {
            $result['session_id'] = $session->session_id;
        }

        if (isset($result['data'])) {
            $result['data'] = json_encode($result['data']);
            $result['data'] = base64_encode($result['data']);
        }

        Yii::info('Результат запроса: ' . serialize($result), 'EndRequest');

        return parent::afterAction($action, $result);
    }
}
