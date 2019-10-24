<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class DeleteDocController extends Controller
{
    /**
     * Проверка состояний
     */
    public function actionIndex()
    {
        Yii::info('Запуск функции actionIndex', __METHOD__);

        $dir = 'uploads/doc';
        foreach (glob($dir."*.docx") as $file) {
            if(time() - filectime($file) > 3600){
                unlink($file);
            }
        }

        Yii::info('Файлы успешно удалены', __METHOD__);

        return true;
    }
}
