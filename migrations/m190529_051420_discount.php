<?php

use yii\db\Migration;

/**
 * Class m190529_051420_discount
 */
class m190529_051420_discount extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `discount` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `code` varchar(45) CHARACTER SET utf8 NOT NULL,
        `name` varchar(45) CHARACTER SET utf8 NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
            ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190529_051420_discount cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190529_051420_discount cannot be reverted.\n";

        return false;
    }
    */
}
