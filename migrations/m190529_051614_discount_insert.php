<?php

use yii\db\Migration;

/**
 * Class m190529_051614_discount_insert
 */
class m190529_051614_discount_insert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `discount` (`id`, `code`, `name`) VALUES ('1', '10', '10%');");
        $this->execute("INSERT INTO `discount` (`id`, `code`, `name`) VALUES ('2', '20', '20%');");
        $this->execute("INSERT INTO `discount` (`id`, `code`, `name`) VALUES ('3', '15', '15%');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190529_051614_discount_insert cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190529_051614_discount_insert cannot be reverted.\n";

        return false;
    }
    */
}
