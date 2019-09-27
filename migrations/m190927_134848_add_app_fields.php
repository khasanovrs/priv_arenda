<?php

use yii\db\Migration;

/**
 * Class m190927_134848_add_app_fields
 */
class m190927_134848_add_app_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `applications_field` (`id`, `code`, `name`) VALUES ('9', 'date_create', 'Дата создания');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190927_134848_add_app_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190927_134848_add_app_fields cannot be reverted.\n";

        return false;
    }
    */
}
