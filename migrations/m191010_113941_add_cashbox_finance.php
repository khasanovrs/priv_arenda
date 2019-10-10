<?php

use yii\db\Migration;

/**
 * Class m191010_113941_add_cashbox_finance
 */
class m191010_113941_add_cashbox_finance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `finance_field` (`id`, `code`, `name`) VALUES ('10', 'cashBox', 'Касса');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191010_113941_add_cashbox_finance cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191010_113941_add_cashbox_finance cannot be reverted.\n";

        return false;
    }
    */
}
