<?php

use yii\db\Migration;

/**
 * Class m190715_064020_fix_application
 */
class m190715_064020_fix_application extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
DROP COLUMN `total_sum`,
DROP COLUMN `delivery_sum`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190715_064020_fix_application cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190715_064020_fix_application cannot be reverted.\n";

        return false;
    }
    */
}
