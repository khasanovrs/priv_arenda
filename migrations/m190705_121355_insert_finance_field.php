<?php

use yii\db\Migration;

/**
 * Class m190705_121355_insert_finance_field
 */
class m190705_121355_insert_finance_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `finance_field` (`id`, `code`, `name`) VALUES ('1', 'number', 'Номер');");
        $this->execute("INSERT INTO `finance_field` (`id`, `code`, `name`) VALUES ('2', 'nazn', 'Назначение');");
        $this->execute("INSERT INTO `finance_field` (`id`, `code`, `name`) VALUES ('3', 'category', 'Категория');");
        $this->execute("INSERT INTO `finance_field` (`id`, `code`, `name`) VALUES ('4', 'type', 'Тип');");
        $this->execute("INSERT INTO `finance_field` (`id`, `code`, `name`) VALUES ('6', 'date', 'Дата');");
        $this->execute("INSERT INTO `finance_field` (`id`, `code`, `name`) VALUES ('7', 'payer', 'Плательщик');");
        $this->execute("INSERT INTO `finance_field` (`id`, `code`, `name`) VALUES ('8', 'sum', 'Сумма');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190705_121355_insert_finance_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190705_121355_insert_finance_field cannot be reverted.\n";

        return false;
    }
    */
}
