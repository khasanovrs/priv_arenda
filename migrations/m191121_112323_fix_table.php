<?php

use yii\db\Migration;

/**
 * Class m191121_112323_fix_table
 */
class m191121_112323_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_sum_delivery` 
DROP FOREIGN KEY `fk_application_sum_hire_1`;
ALTER TABLE `application_sum_delivery` 
DROP COLUMN `application_id`,
DROP INDEX `fk_application_sum_hire_1_idx` ;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_112323_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_112323_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
