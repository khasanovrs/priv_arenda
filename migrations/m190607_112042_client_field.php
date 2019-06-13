<?php

use yii\db\Migration;

/**
 * Class m190607_112042_client_field
 */
class m190607_112042_client_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `client_field` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `code` varchar(45) CHARACTER SET utf8 NOT NULL,
          `name` varchar(150) CHARACTER SET utf8 NOT NULL COMMENT 'наименование поля',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190607_112042_client_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190607_112042_client_field cannot be reverted.\n";

        return false;
    }
    */
}
