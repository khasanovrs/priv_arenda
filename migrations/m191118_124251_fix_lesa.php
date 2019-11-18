<?php

use yii\db\Migration;

/**
 * Class m191118_124251_fix_lesa
 */
class m191118_124251_fix_lesa extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` ADD COLUMN `lesa` VARCHAR(45) NOT NULL DEFAULT 0 COMMENT 'Леса' AFTER `is_not_active`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191118_124251_fix_lesa cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191118_124251_fix_lesa cannot be reverted.\n";

        return false;
    }
    */
}
