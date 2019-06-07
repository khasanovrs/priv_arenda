<?php

use yii\db\Migration;

/**
 * Class m190531_125042_equipments_category
 */
class m190531_125042_equipments_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `equipments_category` (
            `id` int(10) NOT NULL AUTO_INCREMENT,
            `name` varchar(150) COLLATE utf8_bin NOT NULL COMMENT 'Наименование категории',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190531_125042_categoty cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190531_125042_categoty cannot be reverted.\n";

        return false;
    }
    */
}
