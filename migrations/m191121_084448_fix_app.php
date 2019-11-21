<?php

use yii\db\Migration;

/**
 * Class m191121_084448_fix_app
 */
class m191121_084448_fix_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_pay` 
DROP FOREIGN KEY `fk_application_pay_1`;
ALTER TABLE `application_pay` 
DROP COLUMN `group_pay`,
DROP COLUMN `application_equipment_id`,
DROP INDEX `fk_application_pay_1_idx` ;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_084448_fix_app cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_084448_fix_app cannot be reverted.\n";

        return false;
    }
    */
}
