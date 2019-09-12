<?php

use yii\db\Migration;

/**
 * Class m190912_085214_fix_app_eq
 */
class m190912_085214_fix_app_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
ADD COLUMN `hire_date` DATETIME NULL AFTER `remainder`,
ADD COLUMN `renewals_date` DATETIME NULL AFTER `hire_date`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190912_085214_fix_app_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190912_085214_fix_app_eq cannot be reverted.\n";

        return false;
    }
    */
}
