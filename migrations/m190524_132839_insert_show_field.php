<?php

use yii\db\Migration;

/**
 * Class m190524_132839_insert_show_field
 */
class m190524_132839_insert_show_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `show_field_client` (`id`, `code`, `name`, `flag`) VALUES ('1', 'org', 'Организация', 1);");
        $this->execute("INSERT INTO `show_field_client` (`id`, `code`, `name`, `flag`) VALUES ('2', 'fio', 'ФИО', 1);");
        $this->execute("INSERT INTO `show_field_client` (`id`, `code`, `name`, `flag`) VALUES ('4', 'phone', 'Телефон', 1);");
        $this->execute("INSERT INTO `show_field_client` (`id`, `code`, `name`, `flag`) VALUES ('5', 'status', 'Статус', 1);");
        $this->execute("INSERT INTO `show_field_client` (`id`, `code`, `name`, `flag`) VALUES ('6', 'date_create', 'Добавлен', 1);");
        $this->execute("INSERT INTO `show_field_client` (`id`, `code`, `name`, `flag`) VALUES ('7', 'last_contact', 'Последний конт.', 1);");
        $this->execute("INSERT INTO `show_field_client` (`id`, `code`, `name`, `flag`) VALUES ('8', 'source', 'Источник', 1);");
        $this->execute("INSERT INTO `show_field_client` (`id`, `code`, `name`, `flag`) VALUES ('9', 'rentals', 'Прокатов', 1);");
        $this->execute("INSERT INTO `show_field_client` (`id`, `code`, `name`, `flag`) VALUES ('10', 'dohod', 'Доход', 1);");
        $this->execute("INSERT INTO `show_field_client` (`id`, `code`, `name`, `flag`) VALUES ('11', 'sale', 'Скидка', 1);");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190524_132839_insert_show_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190524_132839_insert_show_field cannot be reverted.\n";

        return false;
    }
    */
}
