<?php

use yii\db\Migration;

/**
 * Class m191008_124249_fix_finance
 */
class m191008_124249_fix_finance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("DELETE FROM `finance_field` WHERE `id`='7';");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_124249_fix_finance cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_124249_fix_finance cannot be reverted.\n";

        return false;
    }
    */
}
