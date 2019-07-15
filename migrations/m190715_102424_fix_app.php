<?php

use yii\db\Migration;

/**
 * Class m190715_102424_fix_app
 */
class m190715_102424_fix_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` ADD COLUMN `date_end` DATETIME NULL DEFAULT NULL AFTER `date_create`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190715_102424_fix_app cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190715_102424_fix_app cannot be reverted.\n";

        return false;
    }
    */
}
