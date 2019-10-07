<?php

use yii\db\Migration;

/**
 * Class m191007_074454_fix_app
 */
class m191007_074454_fix_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` ADD COLUMN `is_not_active` VARCHAR(45) NOT NULL DEFAULT 0 AFTER `date_end`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191007_074454_fix_app cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191007_074454_fix_app cannot be reverted.\n";

        return false;
    }
    */
}
