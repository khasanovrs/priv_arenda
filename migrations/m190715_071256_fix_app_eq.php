<?php

use yii\db\Migration;

/**
 * Class m190715_071256_fix_app_eq
 */
class m190715_071256_fix_app_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
ADD COLUMN `total_paid` VARCHAR(45) NOT NULL DEFAULT 0 AFTER `sum`,
ADD COLUMN `remainder` VARCHAR(45) NOT NULL DEFAULT 0 AFTER `total_paid`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190715_071256_fix_app_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190715_071256_fix_app_eq cannot be reverted.\n";

        return false;
    }
    */
}
