<?php

use yii\db\Migration;

/**
 * Class m190614_043532_fix_applications_field
 */
class m190614_043532_fix_applications_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `applications_field` (`id`, `code`, `name`) VALUES ('7', 'user', 'Менеджер');");
        $this->execute("UPDATE `applications_field` SET `code`='phone' WHERE `id`='2';");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190614_043532_fix_applications_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190614_043532_fix_applications_field cannot be reverted.\n";

        return false;
    }
    */
}
