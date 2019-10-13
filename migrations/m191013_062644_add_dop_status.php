<?php

use yii\db\Migration;

/**
 * Class m191013_062644_add_dop_status
 */
class m191013_062644_add_dop_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` ADD COLUMN `dop_status` VARCHAR(500) NULL AFTER `is_not_active`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191013_062644_add_dop_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191013_062644_add_dop_status cannot be reverted.\n";

        return false;
    }
    */
}
