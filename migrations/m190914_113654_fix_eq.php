<?php

use yii\db\Migration;

/**
 * Class m190914_113654_fix_eq
 */
class m190914_113654_fix_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` ADD COLUMN `photo_alias` VARCHAR(250) NULL AFTER `countHire`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190914_113654_fix_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190914_113654_fix_eq cannot be reverted.\n";

        return false;
    }
    */
}
