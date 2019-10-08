<?php

use yii\db\Migration;

/**
 * Class m191008_062959_fix_finance_category
 */
class m191008_062959_fix_finance_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `finance_category` (`id`, `name`) VALUES
(1, 'Аренда помещения'),
(2, 'Гугл Адвордс'),
(3, 'Яндекс Директ'),
(4, 'Расходники'),
(5, 'Ремонт'),
(6, 'Амортизация'),
(7, 'Покупка оборудования'),
(8, 'IT разработка'),
(9, 'Налоги');
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_062959_fix_finance_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_062959_fix_finance_category cannot be reverted.\n";

        return false;
    }
    */
}
