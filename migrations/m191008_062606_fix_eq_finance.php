<?php

use yii\db\Migration;

/**
 * Class m191008_062606_fix_eq_finance
 */
class m191008_062606_fix_eq_finance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("INSERT INTO `finance_cashbox` (`id`, `name`, `sum`, `check_zalog`) VALUES
(1, 'Сбербанк', '0', '0'),
(2, 'НДС (ООО)', '0', '0'),
(3, 'Без НДС (ИП)', '0', '0'),
(4, 'Наличные', '0', '0'),
(5, 'Тиньков', '0', '0'),
(6, 'Залог - сбер', '0', '0'),
(7, 'Залог - ИП', '0', '0'),
(8, 'Залог - ООО', '0', '0'),
(9, 'Залог - наличка', '0', '0');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_062606_fix_eq_finance cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_062606_fix_eq_finance cannot be reverted.\n";

        return false;
    }
    */
}
