<?php

use yii\db\Migration;

/**
 * Class m190523_071301_insert_status
 */
class m190523_071301_insert_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `client_status` (`id`, `name`) VALUES ('1', 'Черный');");
        $this->execute("INSERT INTO `client_status` (`id`, `name`) VALUES ('2', 'С залогом');");
        $this->execute("INSERT INTO `client_status` (`id`, `name`) VALUES ('3', 'Без залога');");
        $this->execute("INSERT INTO `client_status` (`id`, `name`) VALUES ('4', 'Суд');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190523_071301_insert_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190523_071301_insert_status cannot be reverted.\n";

        return false;
    }
    */
}
