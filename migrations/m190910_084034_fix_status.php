<?php

use yii\db\Migration;

/**
 * Class m190910_084034_fix_status
 */
class m190910_084034_fix_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `hire_state` (`id`, `name`) VALUES ('6', 'Замечание');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190910_084034_fix_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190910_084034_fix_status cannot be reverted.\n";

        return false;
    }
    */
}
