<?php

use yii\db\Migration;

/**
 * Class m190713_050900_fix_status_app
 */
class m190713_050900_fix_status_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("UPDATE `applications_status` SET `name` = 'Прокат' WHERE (`id` = '1');");
        $this->execute("UPDATE `applications_status` SET `name` = 'Бронь' WHERE (`id` = '2');");
        $this->execute("UPDATE `applications_status` SET `name` = 'Спрос' WHERE (`id` = '3');");
        $this->execute("UPDATE `applications_status` SET `name` = 'Недоступен' WHERE (`id` = '4');");
        $this->execute("DELETE FROM `applications_status` WHERE (`id` = '5');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190713_050900_fix_status_app cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190713_050900_fix_status_app cannot be reverted.\n";

        return false;
    }
    */
}
