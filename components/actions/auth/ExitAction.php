<?php
/**
 * Выход пользователя
 */

namespace app\components\actions\auth;

use app\components\Session\SessionClass;
use app\models\Session;
use Yii;
use yii\base\Action;

class ExitAction extends Action
{
    public function run()
    {
        Yii::info('Запуск выхода пользователя', __METHOD__);

        /**
         * @var SessionClass $Session
         */
        try {
            $Session = Yii::$app->get('Sessions');
        } catch (\Exception $e) {
            Yii::error('Не смогли найти компонент Session: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        /**
         * @var Session $current_session
         */
        $current_session = $Session->getSession();

        if (!is_object($current_session)) {
            Yii::error('Ошибка при опредении пользователя', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при опредении пользователя'
            ];
        }

        $current_session->status=0;
        $current_session->session_id = '';
        $current_session->session_date_end = date('Y-m-d H:i:s');

        try {
            if (!$current_session->save(false)) {
                Yii::error('Ошибка при выходе: ' . serialize($current_session->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при выходе: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Выход прошел успешно', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Выход прошел успешно'
        ];
    }
}