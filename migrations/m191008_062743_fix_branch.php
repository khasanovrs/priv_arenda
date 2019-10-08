<?php

use yii\db\Migration;

/**
 * Class m191008_062743_fix_branch
 */
class m191008_062743_fix_branch extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("INSERT INTO `branch` (`id`, `name`, `region`) VALUES
(1, 'Казань ', '16'),
(3, 'Самара', '2'),
(4, 'Екатеринбург', '3'),
(5, 'Ижевск', '18'),
(6, 'Ростов-на-Дону', '5'),
(7, 'Тверь', '6'),
(8, 'Липецк', '7'),
(9, 'Пермь', '8'),
(10, 'Пенза', '9'),
(11, 'Рязань', '10'),
(12, 'Тольятти', '11'),
(13, 'Ульяновск', '12'),
(14, 'Иваново', '13'),
(15, 'Ярославль', '14'),
(16, 'Тула', '15'),
(17, 'Смоленск', '16');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_062743_fix_branch cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_062743_fix_branch cannot be reverted.\n";

        return false;
    }
    */
}
