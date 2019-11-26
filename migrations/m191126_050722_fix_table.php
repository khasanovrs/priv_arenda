<?php

use yii\db\Migration;

/**
 * Class m191126_050722_fix_table
 */
class m191126_050722_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `extension` ADD COLUMN `extend` VARCHAR(45) NOT NULL COMMENT '1-продление,0-сокращение' AFTER `type`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191126_050722_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191126_050722_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
