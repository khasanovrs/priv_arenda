<?php

use yii\db\Migration;

/**
 * Class m190915_104120_fix_app_eq
 */
class m190915_104120_fix_app_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
CHANGE COLUMN `hire_state_id` `hire_state_id` INT(11) NOT NULL ;

");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190915_104120_fix_app_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190915_104120_fix_app_eq cannot be reverted.\n";

        return false;
    }
    */
}
