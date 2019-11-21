<?php

use yii\db\Migration;

/**
 * Class m191121_084131_fix_app_eq
 */
class m191121_084131_fix_app_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_equipment` 
DROP COLUMN `remainder`,
DROP COLUMN `total_paid`,
DROP COLUMN `sum_sale`,
DROP COLUMN `sum`,
DROP COLUMN `delivery_sum_paid`,
DROP COLUMN `delivery_sum`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_084131_fix_app_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_084131_fix_app_eq cannot be reverted.\n";

        return false;
    }
    */
}
