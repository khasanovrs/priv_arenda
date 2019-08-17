<?php

use yii\db\Migration;

/**
 * Class m190813_190715_fix_table
 */
class m190813_190715_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_pay` ADD COLUMN `sum` FLOAT(45) NOT NULL AFTER `date_create`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190813_190715_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190813_190715_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
