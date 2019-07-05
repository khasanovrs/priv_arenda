<?php

use yii\db\Migration;

/**
 * Class m190705_133655_finance_cashbox_insert
 */
class m190705_133655_finance_cashbox_insert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `finance_cashbox` (`id`, `name`) VALUES ('1', 'Сбербанк');");
        $this->execute("INSERT INTO `finance_cashbox` (`id`, `name`) VALUES ('2', 'НДС');");
        $this->execute("INSERT INTO `finance_cashbox` (`id`, `name`) VALUES ('3', 'Без НДС');");
        $this->execute("INSERT INTO `finance_cashbox` (`id`, `name`) VALUES ('4', 'Наличные');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190705_133655_finance_cashbox_insert cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190705_133655_finance_cashbox_insert cannot be reverted.\n";

        return false;
    }
    */
}
