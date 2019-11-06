<?php

use yii\db\Migration;

/**
 * Class m191106_113946_fix_field
 */
class m191106_113946_fix_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("UPDATE `hire_field` SET `name` = ' Цена обрудования со скидкой' WHERE (`id` = '8');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191106_113946_fix_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191106_113946_fix_field cannot be reverted.\n";

        return false;
    }
    */
}
