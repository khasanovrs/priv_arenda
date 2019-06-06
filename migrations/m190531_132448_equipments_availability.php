<?php

use yii\db\Migration;

/**
 * Class m190531_132448_equipments_availability
 */
class m190531_132448_equipments_availability extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `equipments_availability` (
          `id` int(11) NOT NULL,
          `name` varchar(150) COLLATE utf8_bin NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190605_132448_equipments_availability cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190605_132448_equipments_availability cannot be reverted.\n";

        return false;
    }
    */
}
