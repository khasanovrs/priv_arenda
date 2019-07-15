<?php

use yii\db\Migration;

/**
 * Class m190715_102835_app_pay
 */
class m190715_102835_app_pay extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_pay` ADD COLUMN `date_create` DATETIME NULL DEFAULT NULL AFTER `user_id`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190715_102835_app_pay cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190715_102835_app_pay cannot be reverted.\n";

        return false;
    }
    */
}
