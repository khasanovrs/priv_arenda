<?php

use yii\db\Migration;

/**
 * Class m190705_133651_finance_cashbox
 */
class m190705_133651_finance_cashbox extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `finance_cashbox` (
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
        echo "m190705_133651_finance_cashbox cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190705_133651_finance_cashbox cannot be reverted.\n";

        return false;
    }
    */
}
