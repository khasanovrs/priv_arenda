<?php

use yii\db\Migration;

/**
 * Class m190929_084310_insert_type_changes
 */
class m190929_084310_insert_type_changes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `type_changes` (`id`, `name`) VALUES ('1', 'Смена склада');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190929_084310_insert_type_changes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190929_084310_insert_type_changes cannot be reverted.\n";

        return false;
    }
    */
}
