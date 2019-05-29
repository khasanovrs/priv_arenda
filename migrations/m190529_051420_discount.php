<?php

use yii\db\Migration;

/**
 * Class m190529_051420_discount
 */
class m190529_051420_discount extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `discount` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `code` VARCHAR(45) NULL,
          `name` VARCHAR(45) NULL,
          PRIMARY KEY (`id`));
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190529_051420_discount cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190529_051420_discount cannot be reverted.\n";

        return false;
    }
    */
}
