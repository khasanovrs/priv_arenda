<?php

use yii\db\Migration;

/**
 * Class m191015_183552_fix_add_sum_sale
 */
class m191015_183552_fix_add_sum_sale extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
ADD COLUMN `sum_sale` VARCHAR(45) NOT NULL DEFAULT 0 AFTER `sum`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191015_183552_fix_add_sum_sale cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191015_183552_fix_add_sum_sale cannot be reverted.\n";

        return false;
    }
    */
}
