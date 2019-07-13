<?php

use yii\db\Migration;

/**
 * Class m190712_150845_fix_eq
 */
class m190712_150845_fix_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` 
DROP COLUMN `sale`,
DROP INDEX `ff_idx` ;
;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190712_150845_fix_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190712_150845_fix_eq cannot be reverted.\n";

        return false;
    }
    */
}
