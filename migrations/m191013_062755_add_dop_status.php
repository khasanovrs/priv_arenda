<?php

use yii\db\Migration;

/**
 * Class m191013_062755_add_dop_status
 */
class m191013_062755_add_dop_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('18', 'dop_status', 'Описание');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191013_062755_add_dop_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191013_062755_add_dop_status cannot be reverted.\n";

        return false;
    }
    */
}
