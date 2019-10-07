<?php

use yii\db\Migration;

/**
 * Class m191007_193529_insert_client_field
 */
class m191007_193529_insert_client_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('12', 'sum_pay', 'Доход');");
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('13', 'count_app', 'Количество прокатов');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191007_193529_insert_client_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191007_193529_insert_client_field cannot be reverted.\n";

        return false;
    }
    */
}
