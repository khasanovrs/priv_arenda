<?php

use yii\db\Migration;

/**
 * Class m190611_183240_applications_field_insert
 */
class m190611_183240_applications_field_insert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `applications_field` (`id`, `code`, `name`) VALUES ('1', 'client', 'Клиент');");
        $this->execute("INSERT INTO `applications_field` (`id`, `code`, `name`) VALUES ('2', 'telephone', 'Номер телефона');");
        $this->execute("INSERT INTO `applications_field` (`id`, `code`, `name`) VALUES ('3', 'interest', 'Что интересует');");
        $this->execute("INSERT INTO `applications_field` (`id`, `code`, `name`) VALUES ('4', 'status', 'Статус');");
        $this->execute("INSERT INTO `applications_field` (`id`, `code`, `name`) VALUES ('5', 'source', 'Источник');");
        $this->execute("INSERT INTO `applications_field` (`id`, `code`, `name`) VALUES ('6', 'comment', 'Комментарий');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190611_183240_applications_field_insert cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_183240_applications_field_insert cannot be reverted.\n";

        return false;
    }
    */
}
