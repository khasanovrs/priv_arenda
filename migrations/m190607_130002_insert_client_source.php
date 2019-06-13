<?php

use yii\db\Migration;

/**
 * Class m190607_130002_insert_client_source
 */
class m190607_130002_insert_client_source extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `client_source` (`id`, `name`) VALUES ('1', 'Сайт');");
        $this->execute("INSERT INTO `client_source` (`id`, `name`) VALUES ('2', 'Звонок');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190607_130002_insert_client_source cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190607_130002_insert_client_source cannot be reverted.\n";

        return false;
    }
    */
}
