<?php

use yii\db\Migration;

/**
 * Class m191008_062704_fix_eq_mark
 */
class m191008_062704_fix_eq_mark extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `equipments_mark` (`id`, `name`) VALUES
(1, 'Makita'),
(2, 'Bosh'),
(3, 'Wacker Neuson'),
(4, 'Ronix'),
(5, 'Bosh'),
(6, 'Husqvarna'),
(7, 'Stihl'),
(8, 'Karcher'),
(9, 'DeWalt'),
(10, 'Dongchang'),
(11, '-');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_062704_fix_eq_mark cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_062704_fix_eq_mark cannot be reverted.\n";

        return false;
    }
    */
}
