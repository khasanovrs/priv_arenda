<?php

use yii\db\Migration;

/**
 * Class m190705_122659_insert_finance_category
 */
class m190705_122659_insert_finance_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `finance_category` (
            `id` int(10) NOT NULL AUTO_INCREMENT,
            `name` varchar(150) CHARACTER SET utf8 NOT NULL COMMENT 'Наименование категории',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190705_122659_insert_finance_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190705_122659_insert_finance_category cannot be reverted.\n";

        return false;
    }
    */
}
