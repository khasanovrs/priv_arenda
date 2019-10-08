<?php

use yii\db\Migration;

/**
 * Class m191008_061910_fix_hire_status
 */
class m191008_061910_fix_hire_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `hire_status` (`id`, `name`, `color`) VALUES ('5', 'Долг', '#ffffff');");
        $this->execute("INSERT INTO `hire_status` (`id`, `name`, `color`) VALUES ('6', 'Закрыт', '#ffffff');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_061910_fix_hire_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_061910_fix_hire_status cannot be reverted.\n";

        return false;
    }
    */
}
