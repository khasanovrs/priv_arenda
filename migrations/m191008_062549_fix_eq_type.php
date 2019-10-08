<?php

use yii\db\Migration;

/**
 * Class m191008_062549_fix_eq_type
 */
class m191008_062549_fix_eq_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `equipments_type` (`id`, `category_id`, `name`) VALUES
(1, 3, 'Отбойный молоток'),
(2, 4, 'Виброплита'),
(3, 4, 'Вибротрамбовка'),
(4, 4, 'Бензорез'),
(5, 4, 'Резчик швов'),
(6, 4, 'Воздуходувка'),
(7, 3, 'Перфоратор'),
(8, 3, 'Штроборез'),
(9, 12, 'Мотобур'),
(10, 11, 'Бензиновый генератор'),
(11, 11, 'Дизельный генератор'),
(12, 9, 'Бетономешалка'),
(13, 5, 'Строительные леса'),
(14, 5, 'Бытовка');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_062549_fix_eq_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_062549_fix_eq_type cannot be reverted.\n";

        return false;
    }
    */
}
