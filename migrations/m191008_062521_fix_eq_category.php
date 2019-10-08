<?php

use yii\db\Migration;

/**
 * Class m191008_062521_fix_eq_category
 */
class m191008_062521_fix_eq_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `equipments_category` (`id`, `name`) VALUES
(3, 'Электроинструмент'),
(4, 'Дорожно-строительная техника'),
(5, 'Временные сооружения'),
(7, 'Клининговое'),
(8, 'Сварка и пайка'),
(9, 'По бетону'),
(10, 'Специнструмент'),
(11, 'Электростанции'),
(12, 'Садовый инструмент'),
(13, 'Шлифовальное'),
(14, 'Измерительные'),
(15, 'Насосное'),
(16, 'Подъемное'),
(17, 'Станки'),
(18, 'Тепловое'),
(19, 'Прочее'),
(20, 'Рекламные материалы');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_062521_fix_eq_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_062521_fix_eq_category cannot be reverted.\n";

        return false;
    }
    */
}
