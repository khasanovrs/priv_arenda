<?php

use yii\db\Migration;

/**
 * Class m191129_085217_fix_table
 */
class m191129_085217_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications_demand` 
DROP COLUMN `delivery_sum`,
DROP COLUMN `rent_end`,
DROP COLUMN `rent_start`,
DROP COLUMN `type_lease_id`,
DROP COLUMN `delivery_id`,
DROP COLUMN `discount_id`,
DROP COLUMN `source_id`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191129_085217_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191129_085217_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
