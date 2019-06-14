<?php

use yii\db\Migration;

/**
 * Class m190614_074637_fix_eq
 */
class m190614_074637_fix_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` 
          ADD COLUMN `photo` VARCHAR(150) NULL AFTER `date_create`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190614_074637_fix_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190614_074637_fix_eq cannot be reverted.\n";

        return false;
    }
    */
}
