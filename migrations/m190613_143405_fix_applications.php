<?php

use yii\db\Migration;

/**
 * Class m190613_143405_fix_applications
 */
class m190613_143405_fix_applications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
          ADD COLUMN `equipments_count` INT(11) NOT NULL AFTER `equipments_id`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_143405_fix_applications cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_143405_fix_applications cannot be reverted.\n";

        return false;
    }
    */
}
