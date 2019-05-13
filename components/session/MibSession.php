<?php
/**
 * Класс для хранения и управления приватной сессией МИБ
 * Date: 30.03.17
 * Time: 9:52
 */

namespace app\components\session;


use app\components\helper\MibHelper;
use app\models\MibSessionsCftSid;
use app\models\MibUsersBindDevices;
use app\models\MibUsersBindDevicesBrowser;
use Yii;
use \yii\base\Component;
use \app\models\MibSessions;

class MibSession extends Component
{
    /**
     * Текущая сессия
     * @var MibSessions $_session ;
     */
    private $_session = null;

    /**
     * Расшифрованные приватные данные от клиента
     * @var null|array
     */
    private $_privateData = null;

    /**
     *
     * @var null|array
     */
    private $_platform = ['mib' => null, 'ua' => null, 'cordova' => null, 'position' => null];


    /**
     * @var null | MibUsersBindDevicesBrowser
     */
    private $_bindDeviceBrowser = null;


    /**
     * @return MibSessions
     */
    public function getSession()
    {
        return $this->_session;
    }

    /**
     * @param MibSessions $session
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
     * @param string $name
     * @return mixed|null
     */
    public function getPrivateData($name = '')
    {
        return (is_object($this->_session) && isset($this->_privateData[$name])) ? $this->_privateData[$name] : null;
    }

    /**
     * @param array $privateData
     */
    public function setPrivateData($privateData)
    {
        if (is_object($this->_session) && is_array($privateData)) {
            if (isset($privateData['platform']) && isset($privateData['platform']['mib']) && isset($privateData['platform']['ua']) && isset($privateData['platform']['cordova'])) {
                $this->_platform = $privateData['platform'];
                unset($privateData['platform']);
            }
            $this->_privateData = $privateData;
        }
    }

    public function cleanSession()
    {
        if (is_object($this->_session)) {
            try {
                // обновляем параметры сессии перед сохранением
                if (!$this->_session->refresh()) {
                    Yii::error('Ошибка при обновлении сессии из базы: ' . serialize($this->_session->getErrors()), __METHOD__);
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при отключении сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
            }
            $this->_session->session_date_end = MibHelper::mibDateMicro('Y-m-d H:i:s.u');
            $this->_session->session_active = 0;
            try {
                if (!$this->_session->save(false)) {
                    Yii::error('Не смогли отключить сессию пользователя: ' . serialize($this->_session->getErrors()), __METHOD__);
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при отключении сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
            }

            $this->_session = null;
            $this->_privateData = null;
        }
    }

    /**
     * Возвращает текущий идентификатор сессии
     * @return string
     */
    public function getSessionId()
    {
        return is_object($this->_session) ? $this->_session->id : '-';
    }

    /**
     * @param $name
     * @return null
     */
    public function getPlatform($name)
    {
        return (is_object($this->_session) && isset($this->_platform[$name])) ? $this->_platform[$name] : null;
    }

    public function getUser()
    {
        return (is_object($this->_session)) ? $this->_session->user : null;
    }

    public function getUserBlockStatus()
    {
        return (is_object($this->_session)) ? $this->_session->user->block_status : null;
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
        $this->_session->session_date_end = MibHelper::mibDateMicro('Y-m-d H:i:s.u', (microtime(true) + Yii::$app->params['mib_session_timeout']));
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

    /**
     * Активация сессии
     * @return bool
     */
    public function activateSession()
    {
        if (!is_object($this->_session)) {
            return false;
        }
        try {
            // обновляем параметры сессии перед сохранением
            if (!$this->_session->refresh()) {
                Yii::error('Ошибка при обновлении сессии из базы: ' . serialize($this->_session->getErrors()), __METHOD__);
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при отключении сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
        }
        $this->_session->session_active = 1;
        $this->_session->session_active_date = date('Y-m-d H:i:s');
        try {
            if (!$this->_session->save(false)) {
                Yii::error('Не смогли активировать сессию пользователя: ' . serialize($this->_session->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при активации сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return true;
    }


    /**
     * @param MibUsersBindDevicesBrowser $bindDeviceBrowser
     * @return bool
     */
    public function setBindDeviceBrowser($bindDeviceBrowser)
    {
        if (!is_object($this->_session)) {
            return false;
        }

        $this->_bindDeviceBrowser = $bindDeviceBrowser;
        try {
            // обновляем параметры сессии перед сохранением
            if (!$this->_session->refresh()) {
                Yii::error('Ошибка при обновлении сессии из базы: ' . serialize($this->_session->getErrors()), __METHOD__);
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при отключении сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
        }
        $this->_session->user_bind_device_browser = $bindDeviceBrowser->id;
        try {
            if (!$this->_session->save(false)) {
                Yii::error('Не смогли сохранить привязанный браузер пользователя в сессию: ' . serialize($this->_session->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении привязанного браузера пользователя в сессию: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return true;
    }

    /**
     * @return MibUsersBindDevicesBrowser|null
     */
    public function getBindDeviceBrowser()
    {
        return $this->_bindDeviceBrowser;
    }

    /**
     * @param MibUsersBindDevices $bindDevice
     * @return bool
     */
    public function setBindDevice($bindDevice)
    {
        if (!is_object($this->_session)) {
            return false;
        }
        try {
            // обновляем параметры сессии перед сохранением
            if (!$this->_session->refresh()) {
                Yii::error('Ошибка при обновлении сессии из базы: ' . serialize($this->_session->getErrors()), __METHOD__);
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при отключении сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
        }
        $this->_session->user_bind_device = $bindDevice->id;
        try {
            if (!$this->_session->save(false)) {
                Yii::error('Не смогли сохранить привязанное мобильное устройство пользователя: ' . serialize($this->_session->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении привязанного мобильного устройства пользователя: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return true;
    }

    /**
     * @return MibUsersBindDevices|null
     */
    public function getBindDevice()
    {
        return $this->_session->userBindDevice;
    }

    /**
     * Возвращает статус мобильной сессии
     * @return bool
     */
    public function isMobileSession()
    {
        return ((int)$this->_session->mobile === 1 && $this->_session->userDevice->device_uuid != '');
    }

    public function getUserId()
    {
        return $this->_session->user_id;
    }

    public function getCftGateSessionId()
    {
        $MibSessionsCftSid = false;
        try {
            Yii::info('Получение идентификатор сессии ЦФТ по идентификатору сессии: session_id=' . serialize($this->_session->id), __METHOD__);

            /**
             * @var MibSessionsCftSid $MibSessionsCftSid
             */
            $MibSessionsCftSid = MibSessionsCftSid::find()
                ->where(['session_id' => $this->_session->id])
                ->one();
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при отключении сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
        }
        $cft_gate_session_id = (is_object($MibSessionsCftSid)) ? $MibSessionsCftSid->cft_gate_session_id : '';
        Yii::info('Получили cft_gate_session_id=' . serialize($cft_gate_session_id), __METHOD__);
        return $cft_gate_session_id;
    }

    /**
     * Установка статуса начала синхронизации в сессии
     * @param string $session_id
     * @return bool
     */
    public static function syncSetStart($session_id)
    {
        Yii::info('Установка запуска синхронизации в сессии: session_id=' . serialize($session_id), __METHOD__);

        if (!ctype_digit((string)$session_id)) {
            Yii::error('Не передан идентификатор сессии', __METHOD__);
            return false;
        }

        try {
            /**
             * @var MibSessionsCftSid $MibSessionsCftSid
             */
            $MibSessionsCftSid = MibSessionsCftSid::find()
                ->where(['session_id' => $session_id])
                ->one();
            if (!is_object($MibSessionsCftSid)) {
                $MibSessionsCftSid = new MibSessionsCftSid();
                $MibSessionsCftSid->session_id = (int)$session_id;
                $MibSessionsCftSid->cft_gate_session_id = '';
            }

            $MibSessionsCftSid->date_sync_start = date('Y-m-d H:i:s');
            $MibSessionsCftSid->sync_status = 1;

            if (!$MibSessionsCftSid->save(false)) {
                Yii::error('Не смогли установить статус начала синхронизации в сессии: ' . serialize($MibSessionsCftSid->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при установке статуса начала синхронизации в сессии: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }
        return true;
    }

    /**
     * Установка статуса окончания синхронизации в сессии
     * @param string $session_id
     * @return bool
     */
    public static function syncSetStop($session_id)
    {
        Yii::info('Установка остановки синхронизации в сессии: session_id=' . serialize($session_id), __METHOD__);

        if (!ctype_digit((string)$session_id)) {
            Yii::error('Не передан идентификатор сессии', __METHOD__);
            return false;
        }

        try {
            /**
             * @var MibSessionsCftSid $MibSessionsCftSid
             */
            $MibSessionsCftSid = MibSessionsCftSid::find()
                ->where(['session_id' => $session_id])
                ->one();
            if (!is_object($MibSessionsCftSid)) {
                Yii::error('Не смогли найти запись сессии: session_id=' . serialize($session_id), __METHOD__);
                return false;
            }

            $MibSessionsCftSid->date_sync_stop = date('Y-m-d H:i:s');
            $MibSessionsCftSid->sync_status = 0;

            if (!$MibSessionsCftSid->save(false)) {
                Yii::error('Не смогли установить статус окончания синхронизации в сессии: ' . serialize($MibSessionsCftSid->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при установке статуса окончания синхронизации в сессии: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }
        return true;
    }


    /**
     * Получение статуса синхронизации в сессии
     * @param string $session_id
     * @return bool | array
     */
    public static function getSyncStatus($session_id)
    {
        Yii::info('Получение статуса синхронизации в сессии: session_id=' . serialize($session_id), __METHOD__);

        if (!ctype_digit((string)$session_id)) {
            Yii::error('Не передан идентификатор сессии', __METHOD__);
            return false;
        }

        try {
            /**
             * @var MibSessionsCftSid $MibSessionsCftSid
             */
            $MibSessionsCftSid = MibSessionsCftSid::find()
                ->where(['session_id' => $session_id])
                ->one();
            if (!is_object($MibSessionsCftSid)) {
                Yii::info('Нет записи сессии: session_id=' . serialize($session_id), __METHOD__);
                return ['session_id' => $session_id, 'status' => 0, 'last_start' => 0];
            }

            return [
                'session_id' => $session_id,
                'status' => $MibSessionsCftSid->sync_status,
                'last_start' => ($MibSessionsCftSid->date_sync_start === '') ? 0 : $MibSessionsCftSid->date_sync_start
            ];
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при установке статуса окончания синхронизации в сессии: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }
    }

    /**
     * Сохранение идентификатора сессии cft-gate в базу
     * @param string $session_id
     * @param $cft_sid
     * @return bool | MibSessions
     */
    public static function saveCftSid($session_id, $cft_sid)
    {
        if (!ctype_digit((string)$session_id)) {
            Yii::error('Не передан идентификатор сессии', __METHOD__);
            return false;
        }
        if (!ctype_digit((string)$cft_sid)) {
            Yii::error('Не передан идентификатор сессии ЦФТ', __METHOD__);
            return false;
        }

        try {
            /**
             * @var MibSessionsCftSid $MibSessionsCftSid
             */
            $MibSessionsCftSid = MibSessionsCftSid::find()
                ->where(['session_id' => $session_id])
                ->one();
            if (!is_object($MibSessionsCftSid)) {
                $MibSessionsCftSid = new MibSessionsCftSid();
                $MibSessionsCftSid->session_id = (int)$session_id;
            }

            $MibSessionsCftSid->cft_gate_session_id = $cft_sid;

            if (!$MibSessionsCftSid->save(false)) {
                Yii::error('Не смогли сохранить идентификатор сессии ЦФТ в сессии: ' . serialize($MibSessionsCftSid->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении идентификатора сессии cft-gate в MibSessionsCftSid: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Сохранили идентификатор сессии ЦФТ в сессию: $session_id=' . serialize($session_id) . '; $MibSessionsCftSid->id=' . serialize($MibSessionsCftSid->id) . '; cft_gate_session_id=' . serialize($MibSessionsCftSid->cft_gate_session_id), __METHOD__);

        return true;
    }
}