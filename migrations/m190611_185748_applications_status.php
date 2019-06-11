<?php

use yii\db\Migration;

/**
 * Class m190611_185748_applications_status
 */
class m190611_185748_applications_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `applications_status` (`id`, `name`) VALUES ('1', 'Ожидает ответа');");
        $this->execute("INSERT INTO `applications_status` (`id`, `name`) VALUES ('2', 'Заявка не обработана');");
        $this->execute("INSERT INTO `applications_status` (`id`, `name`) VALUES ('3', 'Отказ от заказа');");
        $this->execute("INSERT INTO `applications_status` (`id`, `name`) VALUES ('4', 'Заказ по ошибке');");
        $this->execute("INSERT INTO `applications_status` (`id`, `name`) VALUES ('5', 'Заказ подтвержден');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190611_185748_applications_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_185748_applications_status cannot be reverted.\n";

        return false;
    }
    */
}
