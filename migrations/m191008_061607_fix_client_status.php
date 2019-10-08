<?php

use yii\db\Migration;

/**
 * Class m191008_061607_fix_client_status
 */
class m191008_061607_fix_client_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("UPDATE `client_status` SET `name`='С залогом' WHERE `id`='1';");
        $this->execute("UPDATE `client_status` SET `name`='Без залога' WHERE `id`='2';");
        $this->execute("UPDATE `client_status` SET `name`='Суд' WHERE `id`='3';");
        $this->execute("UPDATE `client_status` SET `name`='Приставы' WHERE `id`='4';");
        $this->execute("INSERT INTO `client_status` (`id`, `name`) VALUES ('5', 'Проблемный');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_061607_fix_client_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_061607_fix_client_status cannot be reverted.\n";

        return false;
    }
    */
}
