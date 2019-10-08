<?php

use yii\db\Migration;

/**
 * Class m191008_062307_fix_SOURCE
 */
class m191008_062307_fix_SOURCE extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("UPDATE `source` SET `name`='Яндекс' WHERE `id`='1';");
        $this->execute("UPDATE `source` SET `name`='Инстаграм' WHERE `id`='2';");
        $this->execute("UPDATE `source` SET `name`='Гугл' WHERE `id`='3';");
        $this->execute("INSERT INTO `source` (`id`, `name`) VALUES ('4', 'Вконтакте');");
        $this->execute("INSERT INTO `source` (`id`, `name`) VALUES ('5', 'Знакомые');");
        $this->execute("INSERT INTO `source` (`id`, `name`) VALUES ('6', 'Вывеска');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_062307_fix_SOURCE cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_062307_fix_SOURCE cannot be reverted.\n";

        return false;
    }
    */
}
