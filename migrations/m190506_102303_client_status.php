<?php

use yii\db\Migration;

/**
 * Class m190506_102303_client_status
 */
class m190506_102303_client_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `client_status` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `name` VARCHAR(150) NOT NULL,
          PRIMARY KEY (`id`));
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190507_074603_client_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_074603_client_status cannot be reverted.\n";

        return false;
    }
    */
}
