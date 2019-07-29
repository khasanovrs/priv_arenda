<?php
/**
 * Управление сессиями
 */

namespace app\components\Session;

use Yii;
use \yii\base\Component;
use app\models\Session;

class Sessions extends Component
{
    /**
     * Текущая сессия
     * @var Session $_session ;
     */
    private $_session = null;


    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->_session;
    }

    /**
     * @param Session $session
     */
    public function setSession($session)
    {
        $this->_session = $session;
        Yii::info('Установлена сессия id=' . serialize($this->_session->id), __METHOD__);
    }

    /**
     * Проверка наличия текущей сессии
     * @return bool
     */
    public function checkSession()
    {
        return is_object($this->_session);
    }

    /**
     * Продлеваем срок жизни текущей сессии
     * @return bool
     */
    public function extendSession()
    {
        if (!is_object($this->_session)) {
            return false;
        }

        Yii::info('Продлеваем сессию пользователя', __METHOD__);
        try {
            // обновляем параметры сессии перед сохранением
            if (!$this->_session->refresh()) {
                Yii::error('Ошибка при обновлении сессии из базы: ' . serialize($this->_session->getErrors()), __METHOD__);
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при отключении сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
        }
        $this->_session->session_date_end = date('Y-m-d H:i:s.u', strtotime('+6 hour'));
        try {
            if (!$this->_session->save(false)) {
                Yii::error('Не смогли продлить сессию пользователя: ' . serialize($this->_session->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при продлении сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }
        return true;
    }
}