<?php

use yii\db\Migration;

/**
 * Class m190607_103819_insert_equem_branch
 */
class m190607_103819_insert_equem_branch extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `branch` (`id`, `name`) VALUES ('1', 'Альметьевск');");
        $this->execute("INSERT INTO `branch` (`id`, `name`) VALUES ('2', 'Казань');");
        $this->execute("INSERT INTO `branch` (`id`, `name`) VALUES ('3', 'Набережные Челны');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190607_103819_insert_equem_branch cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190607_103819_insert_equem_branch cannot be reverted.\n";

        return false;
    }
    */
}
