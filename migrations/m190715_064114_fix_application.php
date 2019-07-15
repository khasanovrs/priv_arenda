<?php

use yii\db\Migration;

/**
 * Class m190715_064114_fix_application
 */
class m190715_064114_fix_application extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
ADD COLUMN `delivery_sum` VARCHAR(45) NOT NULL DEFAULT 0 AFTER `equipments_count`,
ADD COLUMN `sum` VARCHAR(45) NOT NULL AFTER `delivery_sum`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190715_064114_fix_application cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190715_064114_fix_application cannot be reverted.\n";

        return false;
    }
    */
}
