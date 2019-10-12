<?php

use yii\db\Migration;

/**
 * Class m191012_063400_add_finance_category
 */
class m191012_063400_add_finance_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `finance_category` (`id`, `name`) VALUES ('10', 'Продажа оборудования');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191012_063400_add_finance_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191012_063400_add_finance_category cannot be reverted.\n";

        return false;
    }
    */
}
