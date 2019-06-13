<?php

use yii\db\Migration;

/**
 * Class m190611_044910_insert_equipments_mark
 */
class m190611_044910_insert_equipments_mark extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `equipments_mark` (`id`, `name`) VALUES ('1', 'Makita');");
        $this->execute("INSERT INTO `equipments_mark` (`id`, `name`) VALUES ('2', 'Bosh');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190611_044910_insert_equipments_mark cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_044910_insert_equipments_mark cannot be reverted.\n";

        return false;
    }
    */
}
