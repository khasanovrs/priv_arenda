<?php

use yii\db\Migration;

/**
 * Class m190607_103628_insert_equem_status
 */
class m190607_103628_insert_equem_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `equipments_status` (`id`, `name`) VALUES ('1', 'В аренде');");
        $this->execute("INSERT INTO `equipments_status` (`id`, `name`) VALUES ('2', 'В ремонте');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190607_103628_insert_equem_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190607_103628_insert_equem_status cannot be reverted.\n";

        return false;
    }
    */
}
