<?php
/**
 * Проверка сессии при любых запросах
 */

namespace app\components\filters;

use app\components\Session\SessionClass;
use app\models\Session;
use Yii;
use yii\base\ActionFilter;
use yii\web\HttpException;

class SessionFilter extends ActionFilter
{
    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $url = $action->uniqueId;

        if ($url == 'api/error') {
            return true;
        }

        $request = Yii::$app->request;
        $sessionId = $request->getBodyParam('sessionId');

        if (!$sessionId && !in_array($url, Yii::$app->params['openMethods'])) {
            Yii::error('Вызванный url не входит в список запросов без сессии - возвращаем ошибку NEED SESSION', __METHOD__);
            throw new HttpException(400, 'NEED SESSION');
        } elseif (!$sessionId) {
            Yii::info('Передан разрешенный без сессии url: ' . serialize($url), __METHOD__);
            return true;
        }

        if (!preg_match('/^[A-Za-z0-9]{20}$/', $sessionId)) {
            Yii::error('Передан некорректный идентификатор сессии', __METHOD__);
            throw new HttpException(400, 'NEED SESSION');
        }

        Yii::info('Получен идентификатор сессии: ' . serialize($sessionId), __METHOD__);

        $session = Session::find()->where('session_id=:session_id and status=1', [':session_id' => $sessionId])->one();

        if (!is_object($session)) {
            Yii::error('Сессия не найдена!', __METHOD__);
            throw new HttpException(400, 'NEED SESSION');
        }

        Yii::info('Сессия найдена: id=' . serialize($session->id), __METHOD__);

        /**
         * @var SessionClass $SessionClass
         */
        try {
            $SessionClass = Yii::$app->get('SessionClass');
        } catch (\Exception $e) {
            Yii::error('Не смогли найти компонент Session: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }
        $SessionClass->setSession($session);

        return true;
    }

    /**
     * @param \yii\base\Action $action
     * @param mixed $result
     * @return bool|mixed
     * @throws HttpException
     */
    public function afterAction($action, $result)
    {
        /**
         * @var Session $Session
         */
        try {
            $Session = Yii::$app->get('Sessions');
        } catch (\Exception $e) {
            Yii::error('Не смогли найти компонент Session: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        if (!$Session->checkSession()) {
            return parent::afterAction($action, $result);
        }

        if (is_array($result) && isset($result['status']) && isset($result['msg'])) {
            if (!$Session->extendSession()) {
                Yii::error('Не смогли продлить сессию', __METHOD__);
                throw new HttpException(400, 'SYSTEM ERROR');
            }
        }

        return parent::afterAction($action, $result);
    }
}