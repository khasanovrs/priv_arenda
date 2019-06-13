<?php

use yii\db\Migration;

/**
 * Class m190613_084326_applications_type_lease_insert
 */
class m190613_084326_applications_type_lease_insert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `applications_type_lease` (`id`, `name`) VALUES ('1', 'Аренда на сутки');");
        $this->execute("INSERT INTO `applications_type_lease` (`id`, `name`) VALUES ('2', 'Аренда на месяц');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_084326_applications_type_lease_insert cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_084326_applications_type_lease_insert cannot be reverted.\n";

        return false;
    }
    */
}
