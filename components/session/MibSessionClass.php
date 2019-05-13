<?php
/**
 * Класс для хранения и управления приватной сессией МИБ
 * Date: 30.03.17
 * Time: 9:52
 */

namespace app\components\session;


use app\components\helper\MibHelper;
use app\models\MibSessionCftClids;
use app\models\MibSessionKeys;
use app\models\MibUsersDevices;
use UAParser\Parser;
use Yii;
use \yii\base\Component;
use \app\models\MibSessions;

class MibSessionClass extends Component
{
    /**
     * Поиск сессии в базе
     * @param $sessionId
     * @param $publicId
     * @param $publicSessionId
     * @param $mobile
     * @return MibSessions|bool
     */
    static function searchSession($sessionId, $publicId, $publicSessionId, $mobile)
    {
        try {
            /**
             * @var MibSessions $session
             */
            $session = MibSessions::find()
                ->joinWith('user')
                ->where(
                    'session_id = :session_id 
                    and pub_id = :pub_id
                    and public_session_id = :public_session_id
                    and mobile = :mobile
                    and session_date_end > now()
                    and mib_users.block_status != 1',
                    [
                        ':session_id' => $sessionId,
                        ':pub_id' => $publicId,
                        ':public_session_id' => $publicSessionId,
                        ':mobile' => $mobile
                    ])
                ->with(['userDevice', 'user'])
                ->limit(1)->one();
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при поиске сессии в базе: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        if (!is_object($session)) {
            Yii::error('Сессия не найдена!', __METHOD__);
            return false;
        }

        return $session;
    }

    static function saveDevice($user_id, $header, $jsAgent, $cordova)
    {
        try {
            $parser = Parser::create();
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при создании определителя устройства пользователя: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        $result = $parser->parse(serialize($jsAgent));
        $browser_name = $result->ua->family;
        $browser_version = $result->ua->toVersion();
        $devices_name = $result->os->family;


        try {
            /**
             * @var MibUsersDevices $tmp
             */
            $tmp = MibUsersDevices::find()->where(
                'user_id = :user_id and 
            status = 0 and 
            device_cordova = :device_cordova and 
            device_model = :device_model and 
            device_platform = :device_platform and 
            device_uuid = :device_uuid and 
            device_version = :device_version and 
            device_manufacturer = :device_manufacturer and 
            device_isVirtual = :device_isVirtual and 
            device_serial = :device_serial and 
            device_touch_id = :device_touch_id and 
            browser_name = :browser_name and 
            browser_version = :browser_version and 
            device_name = :device_name and
            js_agent = :js_agent',
                [
                    ':user_id' => $user_id,
                    ':device_cordova' => $cordova['cordova'],
                    ':device_model' => $cordova['model'],
                    ':device_platform' => $cordova['platform'],
                    ':device_uuid' => $cordova['uuid'],
                    ':device_version' => $cordova['version'],
                    ':device_manufacturer' => $cordova['manufacturer'],
                    ':device_isVirtual' => $cordova['isVirtual'],
                    ':device_serial' => $cordova['serial'],
                    ':device_touch_id' => $cordova['fingerprint'],
                    ':browser_name' => $browser_name,
                    ':browser_version' => $browser_version,
                    ':device_name' => $devices_name,
                    ':js_agent' => serialize($jsAgent)
                ])
                ->limit(1)->one();
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при поиске устройства пользователя в базе: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        if (isset($tmp) && is_object($tmp)) {
            Yii::info('Найдено устройство пользователя: ' . serialize($tmp->id), __METHOD__);
            $MibUsersDevices = $tmp;
        } else {
            $MibUsersDevices = new MibUsersDevices();
            $MibUsersDevices->user_id = $user_id;
            $MibUsersDevices->date_create = MibHelper::mibDateMicro('Y-m-d H:i:s.u');
            $MibUsersDevices->date_modify = MibHelper::mibDateMicro('Y-m-d H:i:s.u');
            $MibUsersDevices->status = 0;
            $MibUsersDevices->device_cordova = $cordova['cordova'];
            $MibUsersDevices->device_model = $cordova['model'];
            $MibUsersDevices->device_platform = $cordova['platform'];
            $MibUsersDevices->device_uuid = $cordova['uuid'];
            $MibUsersDevices->device_version = $cordova['version'];
            $MibUsersDevices->device_manufacturer = $cordova['manufacturer'];
            $MibUsersDevices->device_isVirtual = $cordova['isVirtual'];
            $MibUsersDevices->device_serial = $cordova['serial'];
            $MibUsersDevices->device_touch_id = (string)$cordova['fingerprint'];
            $MibUsersDevices->header = serialize($header);
            $MibUsersDevices->js_agent = serialize($jsAgent);
            $MibUsersDevices->browser_name = $browser_name;
            $MibUsersDevices->browser_version = $browser_version;
            $MibUsersDevices->device_name = $devices_name;
            try {
                if (!$MibUsersDevices->save(false)) {
                    Yii::error('Не смогли создать новое устройство пользователя: ' . serialize($MibUsersDevices->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при создании нового устройства пользователя: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }
            Yii::info('Добавлено новое устройств пользователя: ' . serialize($MibUsersDevices->id), __METHOD__);
        }

        return $MibUsersDevices->id;
    }

    static function saveFakeDevice($user_id)
    {

        try {
            /**
             * @var MibUsersDevices $tmp
             */
            $tmp = MibUsersDevices::find()->where(
                'user_id = :user_id and 
            status = 0 and 
            device_cordova = :device_cordova and 
            device_model = :device_model and 
            device_platform = :device_platform and 
            device_uuid = :device_uuid and 
            device_version = :device_version and 
            device_manufacturer = :device_manufacturer and 
            device_isVirtual = :device_isVirtual and 
            device_serial = :device_serial and 
            device_touch_id = :device_touch_id and 
            browser_name = :browser_name and 
            browser_version = :browser_version and 
            device_name = :device_name',
                [
                    ':user_id' => $user_id,
                    ':device_cordova' => '-',
                    ':device_model' => '-',
                    ':device_platform' => '-',
                    ':device_uuid' => '-',
                    ':device_version' => '-',
                    ':device_manufacturer' => '-',
                    ':device_isVirtual' => '-',
                    ':device_serial' => '-',
                    ':device_touch_id' => '-',
                    ':browser_name' => '-',
                    ':browser_version' => '-',
                    ':device_name' => '-'])
                ->limit(1)->one();
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при поиске устройства пользователя в базе: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        if (isset($tmp) && is_object($tmp)) {
            Yii::info('Найдено устройство пользователя: ' . serialize($tmp->id), __METHOD__);
            $MibUsersDevices = $tmp;
        } else {
            $MibUsersDevices = new MibUsersDevices();
            $MibUsersDevices->user_id = $user_id;
            $MibUsersDevices->date_create = MibHelper::mibDateMicro('Y-m-d H:i:s.u');
            $MibUsersDevices->date_modify = MibHelper::mibDateMicro('Y-m-d H:i:s.u');
            $MibUsersDevices->status = 0;
            $MibUsersDevices->device_cordova = '-';
            $MibUsersDevices->device_model = '-';
            $MibUsersDevices->device_platform = '-';
            $MibUsersDevices->device_uuid = '-';
            $MibUsersDevices->device_version = '-';
            $MibUsersDevices->device_manufacturer = '-';
            $MibUsersDevices->device_isVirtual = '-';
            $MibUsersDevices->device_serial = '-';
            $MibUsersDevices->device_touch_id = '-';
            $MibUsersDevices->header = '-';
            $MibUsersDevices->js_agent = '-';
            $MibUsersDevices->browser_name = '-';
            $MibUsersDevices->browser_version = '-';
            $MibUsersDevices->device_name = '-';
            try {
                if (!$MibUsersDevices->save(false)) {
                    Yii::error('Не смогли создать новое устройство пользователя: ' . serialize($MibUsersDevices->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при создании нового устройства пользователя: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }
            Yii::info('Добавлено новое устройств пользователя: ' . serialize($MibUsersDevices->id), __METHOD__);
        }

        return $MibUsersDevices->id;
    }


    /**
     * Формирование новой сессии пользователя
     * @param $user_id
     * @param $mib_version
     * @param $userIP
     * @param $publicId
     * @param $publicSessionId
     * @param $mobile
     * @param $header
     * @param $jsAgent
     * @param $cordova
     * @param null $user_bind_device_id
     * @return bool | MibSessions
     */
    static function generateSession($user_id, $mib_version, $userIP, $publicId, $publicSessionId, $mobile, $header, $jsAgent, $cordova, $user_bind_device_id = null)
    {
        Yii::debug('Формирование новой сессии пользователя', __METHOD__);

        // сохраняем информацию по устройству пользователя
        $dev_id = MibSessionClass::saveDevice($user_id, $header, $jsAgent, $cordova);

        if (!$dev_id || !ctype_digit((string)$dev_id)) {
            Yii::error('Не смогли сохранить устройство пользователя', __METHOD__);
            return false;
        }

        Yii::info('Идентификатор устройства пользователя: ' . serialize($dev_id), __METHOD__);

        $session = new MibSessions();
        $session->session_date = MibHelper::mibDateMicro('Y-m-d H:i:s.u');
        $session->session_date_end = MibHelper::mibDateMicro('Y-m-d H:i:s.u', (microtime(true) + Yii::$app->params['mib_session_timeout']));
        $session->session_active = 0;
        $session->session_id = MibHelper::randomString(255);
        $session->session_ip = $userIP;
        $session->user_id = $user_id;
        $session->user_device_id = $dev_id;
        $session->public_session_id = (string)$publicSessionId;
        $session->mib_version = str_replace('.', '', $mib_version);

        $session->pub_id = $publicId;
        $session->mobile = (int)$mobile;

        if (ctype_digit((string)$user_bind_device_id)) {
            $session->user_bind_device = $user_bind_device_id;
        }

        $session->session_key = MibHelper::randomString(64);
        $session->check_string = MibHelper::randomString(10);

        try {
            if (!$session->save(false)) {
                Yii::error('Не смогли создать новую сессию: ' . serialize($session->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при создании новой сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        if (!MibSessionClass::saveSessionKey($session->id, $session->session_key, $session->check_string)) {
            Yii::error('Не смогли сохранить в историю новый ключ сессии пользователя', __METHOD__);
            return false;
        }

        Yii::info('Создана сессия: id=' . serialize($session->id), __METHOD__);
        return $session;
    }


    /**
     * Формирование новой активной сессии пользователя
     * @param $user_id
     * @param $mib_version
     * @param $userIP
     * @param $publicId
     * @param $publicSessionId
     * @param $mobile
     * @param $header
     * @param $jsAgent
     * @param $cordova
     * @param null $user_bind_device_id
     * @return bool | MibSessions
     */
    static function generateActiveSession($user_id, $mib_version, $userIP, $publicId, $publicSessionId, $mobile, $header, $jsAgent, $cordova, $user_bind_device_id = null)
    {
        Yii::debug('Формирование новой сессии пользователя', __METHOD__);

        // сохраняем информацию по устройству пользователя
        $dev_id = MibSessionClass::saveDevice($user_id, $header, $jsAgent, $cordova);

        if (!$dev_id || !ctype_digit((string)$dev_id)) {
            Yii::error('Не смогли сохранить устройство пользователя', __METHOD__);
            return false;
        }

        Yii::info('Идентификатор устройства пользователя: ' . serialize($dev_id), __METHOD__);

        $session = new MibSessions();
        $session->session_date = MibHelper::mibDateMicro('Y-m-d H:i:s.u');
        $session->session_date_end = MibHelper::mibDateMicro('Y-m-d H:i:s.u', (microtime(true) + Yii::$app->params['mib_session_timeout']));
        $session->session_active = 1;
        $session->session_active_date = date('Y-m-d H:i:s');
        $session->session_id = MibHelper::randomString(255);
        $session->session_ip = $userIP;
        $session->user_id = $user_id;
        $session->user_device_id = $dev_id;
        $session->public_session_id = (string)$publicSessionId;
        $session->mib_version = str_replace('.', '', $mib_version);

        $session->pub_id = $publicId;
        $session->mobile = (int)$mobile;

        if (ctype_digit((string)$user_bind_device_id)) {
            $session->user_bind_device = $user_bind_device_id;
        }

        $session->session_key = MibHelper::randomString(64);
        $session->check_string = MibHelper::randomString(10);

        try {
            if (!$session->save(false)) {
                Yii::error('Не смогли создать новую сессию: ' . serialize($session->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при создании новой сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        if (!MibSessionClass::saveSessionKey($session->id, $session->session_key, $session->check_string)) {
            Yii::error('Не смогли сохранить в историю новый ключ сессии пользователя', __METHOD__);
            return false;
        }

        Yii::info('Создана сессия: id=' . serialize($session->id), __METHOD__);
        return $session;
    }

    /**
     * Формирование сессии-заглушки пользователя
     * @param $user_id
     * @return bool | MibSessions
     */
    static function generateFakeSession($user_id)
    {
        Yii::info('Формирование сессии-заглушки пользователя', __METHOD__);

        // сохраняем информацию по устройству пользователя
        $dev_id = MibSessionClass::savefakeDevice($user_id);

        if (!$dev_id || !ctype_digit((string)$dev_id)) {
            Yii::error('Не смогли сохранить устройство пользователя', __METHOD__);
            return false;
        }

        Yii::info('Идентификатор устройства пользователя: ' . serialize($dev_id), __METHOD__);

        $session = new MibSessions();
        $session->session_date = MibHelper::mibDateMicro('Y-m-d H:i:s.u');
        $session->session_date_end = MibHelper::mibDateMicro('Y-m-d H:i:s.u', (microtime(true) + Yii::$app->params['mib_session_timeout']));
        $session->session_active = 0;
        $session->session_id = MibHelper::randomString(255);
        $session->session_ip = '127.0.0.1';
        $session->user_id = $user_id;
        $session->user_device_id = $dev_id;
        $session->public_session_id = '-';
        $session->mib_version = '270';

        $session->pub_id = '-';
        $session->mobile = 0;

        $session->session_key = '-';
        $session->check_string = '-';

        try {
            if (!$session->save(false)) {
                Yii::error('Не смогли создать новую сессию: ' . serialize($session->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при создании новой сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Создана сессия: id=' . serialize($session->id), __METHOD__);
        return $session;
    }

    /**
     * @param int $session_id
     * @param string $newKey
     * @param string $newCheckString
     * @return bool
     */
    static function saveSessionKey($session_id, $newKey, $newCheckString)
    {
        Yii::debug('Сохранение в историю нового ключа сессии пользователя', __METHOD__);

        $create_time = microtime(true);

        $MibSessionKeys = new MibSessionKeys();
        $MibSessionKeys->session_id = $session_id;
        $MibSessionKeys->key_date = date('Y-m-d H:i:s', $create_time);
        $MibSessionKeys->key_time = MibHelper::mibDateMicro('Y-m-d H:i:s.u', $create_time);
        $MibSessionKeys->session_key = $newKey;
        $MibSessionKeys->session_key_check_string = $newCheckString;

        try {
            if (!$MibSessionKeys->save(false)) {
                Yii::error('Не смогли сохранить новый ключ сессии: ' . serialize($MibSessionKeys->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении нового ключа сессии: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return true;
    }

    /**
     * Расшифровка приватных данных ключами сессии
     * @param MibSessions $session
     * @param string $prBlock
     * @return bool | array
     */
    static function decryptPrBlock($session, $prBlock)
    {
        if (!is_object($session)) {
            Yii::error('Сессия не объект', __METHOD__);
            return false;
        }

        $count = 1;

        foreach (MibSessionKeys::find()->where('session_id=:session_id', [':session_id' => $session->id])->orderBy('id desc')->each() as $key) {
            /**
             * @var MibSessionKeys $key
             */
            Yii::info('Для расшифровки используем ключ id=' . serialize($key->id), __METHOD__);
            $tmpPrBlock = MibHelper::mib_decrypt_data(substr($key->session_key, 0, 32), substr($key->session_key, 32, 32), $prBlock);

            if (is_array($tmpPrBlock) && isset($tmpPrBlock['checkString']) && preg_match('/^[A-Za-z0-9]{10}$/', $tmpPrBlock['checkString']) && (string)$tmpPrBlock['checkString'] === (string)$key->session_key_check_string) {
                Yii::info('Расшифровка приватных данных успешна', __METHOD__);
                unset($tmpPrBlock['checkString']);
                return $tmpPrBlock;
            }

            /*if ($count > Yii::$app->params['count_key_decrypt']) {
                Yii::error('Превышено количество попыток подбора ключей шифрования: ' . serialize(Yii::$app->params['count_key_decrypt']), __METHOD__);
                return false;
            }
            */
            Yii::error('Не смогли расшифровать приватные данные от клиента: count=' . serialize($count), __METHOD__);

            Yii::error('Причина: is_array=' . serialize(is_array($tmpPrBlock)) . '; isset checkString=' . serialize(isset($tmpPrBlock['checkString'])) . '; correct checkString=' . serialize(preg_match('/^[A-Za-z0-9]{10}$/', $tmpPrBlock['checkString'])) . '; same checkString=' . serialize($tmpPrBlock['checkString'] === (string)$key->session_key_check_string), __METHOD__);
            $count++;
        }

        return false;
    }

    /**
     * Шифровка приватных данных сессионным ключом и генерация нового сессионного ключа
     * @param MibSessions $session
     * @param $prData
     * @return bool
     */
    public static function encryptPrData($session, $prData)
    {
        if (!is_object($session)) {
            Yii::error('Сессия не объект', __METHOD__);
            return false;
        }

        /*
        if (isset($prData['status']) && $prData['status'] !== 'ERROR') {
            $prData['newPrKey']['key'] = MibHelper::randomString(64);
            $prData['newPrKey']['checkString'] = MibHelper::randomString(10);
        }
        */

        $result = MibHelper::mib_encrypt_data(substr($session->session_key, 0, 32), substr($session->session_key, 32, 32), $prData);

        /*
        if (isset($prData['status']) && $prData['status'] !== 'ERROR') {
            try {
                // обновляем параметры сессии перед сохранением
                if (!$session->refresh()) {
                    Yii::error('Ошибка при обновлении сессии из базы: ' . serialize($session->getErrors()), __METHOD__);
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при отключении сессии пользователя: ' . serialize($e->getMessage()), __METHOD__);
            }

            $session->session_key = $prData['newPrKey']['key'];
            $session->check_string = $prData['newPrKey']['checkString'];

            try {
                if (!$session->save(false)) {
                    Yii::error('Не смогли сохранить новый ключ сессии: ' . serialize($session->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при сохранении нового ключа сессии: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            if (!MibSessionClass::saveSessionKey($session->id, $session->session_key, $session->check_string)) {
                Yii::error('Не смогли сохранить в историю новый ключ сессии пользователя', __METHOD__);
                return false;
            }
        }
        */

        return $result;
    }

    /**
     * @param $session_id
     * @return MibSessions|bool
     */
    public static function searchSessionById($session_id)
    {
        if (!ctype_digit((string)$session_id)) {
            Yii::error('Передан не цифровой идентификатор пользователя', __METHOD__);
            return false;
        }

        try {
            /**
             * @var MibSessions $MibSession
             */
            $MibSession = MibSessions::findOne($session_id);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при поиске пользователя по идентификатору: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        if (!is_object($MibSession)) {
            return false;
        }

        return $MibSession;
    }


    /**
     * Сохранение актуальных идентификаторов клиентов ЦФТ из cft-gate в сессию
     * @param MibSessions $session
     * @param $cft_clids
     * @return bool
     */
    public static function saveCftClids(MibSessions $session, array $cft_clids)
    {
        if (!is_object($session)) {
            Yii::error('Сессия не объект', __METHOD__);
            return false;
        }
        if (!is_array($cft_clids)) {
            Yii::error('Список идентификаторов ЦФТ не массив', __METHOD__);
            return false;
        }

        foreach ($cft_clids as $cft_clid) {
            $MibSessionCftClids = new MibSessionCftClids();
            $MibSessionCftClids->session_id = $session->id;
            $MibSessionCftClids->cft_clid = $cft_clid['cft_clid'];
            $MibSessionCftClids->card_agid = $cft_clid['agid'];

            try {
                if (!$MibSessionCftClids->save(false)) {
                    Yii::error('Не смогли сохранить список идентификаторов клиентов ЦФТ из cft-gate в базу: ' . serialize($MibSessionCftClids->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при сохранении списка идентификаторов клиентов ЦФТ из cft-gate в базу: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }
        }

        return true;
    }

    /**
     * @param MibSessions $session
     * @return array|string
     */
    public static function getCftClids(MibSessions $session)
    {
        if (!is_object($session)) {
            Yii::error('Сессия не объект', __METHOD__);
            return '';
        }

        try {
            $MibSessionCftClids = $session->mibSessionCftClids;
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при поиске списка идентификаторов клиентов ЦФТ в базе: ' . serialize($e->getMessage()), __METHOD__);
            return '';
        }

        $clids = [];
        foreach ($MibSessionCftClids as $MibSessionCftClid) {
            if (ctype_digit((string)$MibSessionCftClid->cft_clid) && !in_array($MibSessionCftClid->cft_clid, $clids)) {
                $clids[] = $MibSessionCftClid->cft_clid;
            }
        }

        if (count($clids) <= 0) {
            $clids = '';
        }

        Yii::info('Получили список cft_clids=' . serialize($clids), __METHOD__);

        return $clids;
    }

    /**
     * Синхронизация переменной сессии с базой
     * @param MibSessions $session
     * @return MibSessions|bool
     */
    public static function refreshSession(MibSessions $session)
    {
        if (!is_object($session)) {
            Yii::error('Сессия не объект', __METHOD__);
            return false;
        }

        try {
            if (!$session->refresh()) {
                Yii::error('Не смогли обновить данные сессии из базы: ' . serialize($session->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении данных сессии из базы: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        /**
         * @var MibSession $MibSession
         */
        try {
            $MibSession = Yii::$app->get('MibSession');
        } catch (\Exception $e) {
            Yii::error('Не смогли найти компонент MibSession: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        $MibSession->setSession($session);

        return $session;
    }
}