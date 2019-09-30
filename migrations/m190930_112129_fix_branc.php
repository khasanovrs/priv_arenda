<?php

use yii\db\Migration;

/**
 * Class m190930_112129_fix_branc
 */
class m190930_112129_fix_branc extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `branch` ADD COLUMN `region` VARCHAR(45) NOT NULL AFTER `name`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190930_112129_fix_branc cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190930_112129_fix_branc cannot be reverted.\n";

        return false;
    }
    */
}
