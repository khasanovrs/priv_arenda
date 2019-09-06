<?php

use yii\db\Migration;

/**
 * Class m190906_073055_fix_status
 */
class m190906_073055_fix_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('16', 'state', 'Состояние');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190906_073055_fix_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190906_073055_fix_status cannot be reverted.\n";

        return false;
    }
    */
}
