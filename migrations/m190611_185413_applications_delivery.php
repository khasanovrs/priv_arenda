<?php

use yii\db\Migration;

/**
 * Class m190611_185413_applications_delivery
 */
class m190611_185413_applications_delivery extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `applications_delivery` (`id`, `name`) VALUES ('1', 'С доставкой');");
        $this->execute("INSERT INTO `applications_delivery` (`id`, `name`) VALUES ('2', 'Без доставки');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190611_185413_applications_delivery cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_185413_applications_delivery cannot be reverted.\n";

        return false;
    }
    */
}
