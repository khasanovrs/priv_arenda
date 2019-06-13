<?php

use yii\db\Migration;

/**
 * Class m190531_134428_equipments_type
 */
class m190531_134428_equipments_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `equipments_type` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(150) COLLATE utf8_bin DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190531_134428_equipments_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190531_134428_equipments_type cannot be reverted.\n";

        return false;
    }
    */
}
