<?php

use yii\db\Migration;

/**
 * Class m190911_082942_fix_eq
 */
class m190911_082942_fix_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE`equipments` 
ADD COLUMN `countHire` VARCHAR(45) NOT NULL DEFAULT 0 COMMENT 'количество прокатов' AFTER `photo`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190911_082942_fix_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190911_082942_fix_eq cannot be reverted.\n";

        return false;
    }
    */
}
