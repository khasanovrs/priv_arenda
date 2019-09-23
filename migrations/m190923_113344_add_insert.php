<?php

use yii\db\Migration;

/**
 * Class m190923_113344_add_insert
 */
class m190923_113344_add_insert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('17', 'comment', 'Комментарий');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190923_113344_add_insert cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_113344_add_insert cannot be reverted.\n";

        return false;
    }
    */
}
