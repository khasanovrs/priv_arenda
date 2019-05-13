<?php
/**
 * Проверка приватного блока и расшифровка параметров
 */

namespace app\components\filters;

use app\components\session\MibSession;
use app\components\session\MibSessionClass;
use app\components\Session\Sessions;
use Yii;
use yii\base\ActionFilter;

class PrBlockFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $url = $action->uniqueId;

        if ($url == 'api/error') {
            return true;
        }

        /**
         * @var Sessions $Sessions
         */
        $Sessions = Yii::$app->get('Sessions');
        if (!$Sessions->checkSession()) {
            return true;
        }

        $request = Yii::$app->request;

        $prBlock = $request->getBodyParam('prBlock');

        $session = $MibSession->getSession();

        if ((!empty($prBlock) && is_string($prBlock) && preg_match('`^[a-zA-Z0-9+/]+={0,2}$`', $prBlock)) || is_array($prBlock)) {
            Yii::info('Определили наличие приватного блока', __METHOD__);

            if (!is_array($prBlock)) {
                $prBlock = MibSessionClass::decryptPrBlock($session, $prBlock);
            }

            if (is_array($prBlock)) {
                $MibSession->setPrivateData($prBlock);
            } else {
                Yii::error('Ошибка! Расшифрованных данных нет или это не json: data=' . serialize($prBlock), __METHOD__);
            }
        }

        return true;
    }

    public function afterAction($action, $result)
    {
        /**
         * @var MibSession $MibSession
         */
        try {
            $MibSession = Yii::$app->get('MibSession');
        } catch (\Exception $e) {
            Yii::error('Не смогли найти компонент MibSession: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        if (!$MibSession->checkSession()) {
            return parent::afterAction($action, $result);
        }

        $url = $action->uniqueId;

        if (in_array($url, Yii::$app->params['notEncryptPrData'])) {
            return parent::afterAction($action, $result);
        }

        $session = $MibSession->getSession();

        $tmp_result = [];

        if (is_array($result) && isset($result['status']) && isset($result['code'])) {
            $tmp_result = [
                'status' => $result['status'],
                'code' => $result['code']
            ];
            unset($result['status'], $result['code']);
        }
        if (isset($result['answer'])) {
            $tmp_result['answer'] = $result['answer'];
            unset($result['answer']);
        }
        if (isset($result['msg'])) {
            $tmp_result['msg'] = $result['msg'];
            unset($result['msg']);
        }
        if (isset($result['advice'])) {
            $tmp_result['advice'] = $result['advice'];
            unset($result['advice']);
        }

        if (!is_array($result) || count($result) === 0) {
            $result = [];
        }

        $tmp_result['prData'] = MibSessionClass::encryptPrData($session, $result);

        return parent::afterAction($action, $tmp_result);
    }
}