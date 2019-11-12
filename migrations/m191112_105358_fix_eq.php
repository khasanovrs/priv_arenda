<?php

use yii\db\Migration;

/**
 * Class m191112_105358_fix_eq
 */
class m191112_105358_fix_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` ADD COLUMN `comment` VARCHAR(500) NULL AFTER `confirmed`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191112_105358_fix_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191112_105358_fix_eq cannot be reverted.\n";

        return false;
    }
    */
}
