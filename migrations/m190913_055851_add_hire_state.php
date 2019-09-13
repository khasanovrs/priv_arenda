<?php

use yii\db\Migration;

/**
 * Class m190913_055851_add_hire_state
 */
class m190913_055851_add_hire_state extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `hire_state` (`id`, `name`) VALUES ('7', 'Продление');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190913_055851_add_hire_state cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190913_055851_add_hire_state cannot be reverted.\n";

        return false;
    }
    */
}
