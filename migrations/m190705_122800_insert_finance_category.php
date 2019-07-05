<?php

use yii\db\Migration;

/**
 * Class m190705_122800_insert_finance_category
 */
class m190705_122800_insert_finance_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO  `finance_category` (`id`, `name`) VALUES ('1', 'Аренда помещения');");
        $this->execute("INSERT INTO  `finance_category` (`id`, `name`) VALUES ('2', 'Аренда обрудования');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190705_122800_insert_finance_category cannot be reverted . \n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190705_122800_insert_finance_category cannot be reverted . \n";

        return false;
    }
    */
}
