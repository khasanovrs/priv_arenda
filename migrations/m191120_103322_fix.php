<?php

use yii\db\Migration;

/**
 * Class m191120_103322_fix
 */
class m191120_103322_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("DELETE FROM `hire_lesa_field` WHERE `id`='26';");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191120_103322_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191120_103322_fix cannot be reverted.\n";

        return false;
    }
    */
}
