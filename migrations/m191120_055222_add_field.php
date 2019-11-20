<?php

use yii\db\Migration;

/**
 * Class m191120_055222_add_field
 */
class m191120_055222_add_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
            ADD COLUMN `month_sum` VARCHAR(150) NOT NULL DEFAULT 0 AFTER `lesa`,
            ADD COLUMN `square` VARCHAR(45) NOT NULL DEFAULT 0 AFTER `month_sum`,
            ADD COLUMN `address` VARCHAR(500) NOT NULL DEFAULT 0 AFTER `square`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191120_055222_add_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191120_055222_add_field cannot be reverted.\n";

        return false;
    }
    */
}
