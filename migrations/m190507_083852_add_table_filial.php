<?php

use yii\db\Migration;

/**
 * Class m190507_083852_add_table_filial
 */
class m190507_083852_add_table_filial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `branch` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `name` VARCHAR(150) NOT NULL,
          PRIMARY KEY (`id`));
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190507_083852_add_table_filial cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_083852_add_table_filial cannot be reverted.\n";

        return false;
    }
    */
}
