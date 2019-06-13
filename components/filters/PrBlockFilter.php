<?php
/**
 * Проверка приватного блока и расшифровка параметров
 */

namespace app\components\filters;

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

        $request = Yii::$app->request;
        $prBlock = $request->getBodyParam('prBlock');

        if ((!empty($prBlock) && is_string($prBlock) && preg_match('`^[a-zA-Z0-9+/]+={0,2}$`', $prBlock)) || is_array($prBlock)) {
            Yii::info('Определили наличие приватного блока', __METHOD__);

            if (!is_array($prBlock)) {
                $prBlock = base64_decode($prBlock);
                $prBlock = json_decode($prBlock);
            }
        }

        $request->setBodyParams($prBlock);

        return true;
    }

    public function afterAction($action, $result)
    {
        return parent::afterAction($action, $result);
    }
}