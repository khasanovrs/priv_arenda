<?php

use yii\db\Migration;

/**
 * Class m190705_131631_insert_finance_type
 */
class m190705_131631_insert_finance_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `finance_type` (`id`, `name`) VALUES ('1', 'Расход');");
        $this->execute("INSERT INTO `finance_type` (`id`, `name`) VALUES ('2', 'Доход');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190705_131631_insert_finance_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190705_131631_insert_finance_type cannot be reverted.\n";

        return false;
    }
    */
}
