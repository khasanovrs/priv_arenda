<?php

use yii\db\Migration;

/**
 * Class m190910_084434_fix_field
 */
class m190910_084434_fix_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("UPDATE `hire_field` SET `code`='state' WHERE `id`='6';");
        $this->execute("DELETE FROM `hire_field` WHERE `id`='16';");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190910_084434_fix_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190910_084434_fix_field cannot be reverted.\n";

        return false;
    }
    */
}
