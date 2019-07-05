<?php

use yii\db\Migration;

/**
 * Class m190705_131546_finance_type
 */
class m190705_131546_finance_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `finance_type` (
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
        echo "m190705_131546_finance_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190705_131546_finance_type cannot be reverted.\n";

        return false;
    }
    */
}
