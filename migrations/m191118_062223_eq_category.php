<?php

use yii\db\Migration;

/**
 * Class m191118_062223_eq_category
 */
class m191118_062223_eq_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $ll = 'Электроинструмент,Дорожно-строительная техника,Временные сооружения,Клининговое,Сварка и пайка,По бетону,Специнструмент,Электростанции,Садовый инструмент,Шлифовальное,Измерительные,Насосное,Подъемное,Станки,Тепловое,Прочее,Рекламные материалы,Отбойные молотки,Генераторы,Клиннинговое оборудование,Пушки тепловые,Садовый инструмент,Шлифовальное/строгальное оборудование,Дорожно строительная техника,Оборудования для бетона,Электроинструмент,Компрессоры и насосы,Вышка тура,Сварка и пайка,Прочее,Измерительный инструмент,Бытовки,Подъемное оборудование,Леса строительные';

        $arr = explode(',', $ll);

        asort($arr);

        foreach ($arr as $value) {
            $newCategory = new \app\models\EquipmentsCategory();

            $newCategory->name = $value;

            try {
                if (!$newCategory->save(false)) {
                    Yii::error('Ошибка при сохранении категории: ' . serialize($newCategory->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при сохранении категории: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191118_062223_eq_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191118_062223_eq_category cannot be reverted.\n";

        return false;
    }
    */
}
