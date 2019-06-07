<?php

use yii\db\Migration;

/**
 * Class m190607_112203_insert_client_field
 */
class m190607_112203_insert_client_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('1', 'org', 'Организация');");
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('2', 'fio', 'ФИО');");
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('4', 'phone', 'Телефон');");
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('5', 'status', 'Статус');");
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('6', 'date_create', 'Добавлен');");
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('7', 'last_contact', 'Последний конт.');");
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('8', 'source', 'Источник');");
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('9', 'rentals', 'Прокатов');");
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('10', 'dohod', 'Доход');");
        $this->execute("INSERT INTO `client_field` (`id`, `code`, `name`) VALUES ('11', 'sale', 'Скидка');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190607_112203_insert_client_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190607_112203_insert_client_field cannot be reverted.\n";

        return false;
    }
    */
}
