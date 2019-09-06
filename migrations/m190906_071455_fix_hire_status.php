<?php

use yii\db\Migration;

/**
 * Class m190906_071455_fix_hire_status
 */
class m190906_071455_fix_hire_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("DELETE FROM `hire_status` WHERE `id`='4';");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190906_071455_fix_hire_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190906_071455_fix_hire_status cannot be reverted.\n";

        return false;
    }
    */
}
