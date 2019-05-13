<?php
/**
 * Класс для хранения и управления приватной сессией
 * Date: 30.03.17
 * Time: 9:52
 */

namespace app\components\Session;


use Yii;
use \yii\base\Component;
use app\models\Session;
use app\components\helper\helperClass;

class SessionClass extends Component
{
    /**
     * Добавление новой сессии
     * @param $userId
     * @return bool|array
     */
    public static function AddNewSession($userId)
    {
        Yii::info('Запуск функции добавления новой сессии', __METHOD__);

        $newSession = new Session();
        $newSession->user_id = $userId;
        $newSession->session_date = date('Y-m-d H:i:s');
        $newSession->session_id = helperClass::generateRandomString(20);
        $newSession->status = 1;

        try {
            if (!$newSession->save(false)) {
                Yii::error('Ошибка при сохраненнии новой сессии: ' . serialize($newSession->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохраненнии новой сессии: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Сессия успешно сохранена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Сессия успешно добавлена'
        ];
    }
}