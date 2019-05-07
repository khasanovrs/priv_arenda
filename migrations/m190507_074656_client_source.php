<?php

use yii\db\Migration;

/**
 * Class m190507_074656_client_source
 */
class m190507_074656_client_source extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE `client_source` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(150) NOT NULL,
            PRIMARY KEY (`id`));
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190507_074656_client_source cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_074656_client_source cannot be reverted.\n";

        return false;
    }
    */
}
