<?php

use yii\db\Migration;

/**
 * Class m191008_062044_fix_eq_status
 */
class m191008_062044_fix_eq_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `equipments_status` (`id`, `name`, `color`) VALUES ('3', 'Списан', '#ffffff');");
        $this->execute("INSERT INTO `equipments_status` (`id`, `name`, `color`) VALUES ('4', 'Доступен', '#ffffff');");
        $this->execute("INSERT INTO `equipments_status` (`id`, `name`, `color`) VALUES ('5', 'Бронь', '#ffffff');");
        $this->execute("INSERT INTO `equipments_status` (`id`, `name`, `color`) VALUES ('6', 'Продан', '#ffffff');");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_062044_fix_eq_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_062044_fix_eq_status cannot be reverted.\n";

        return false;
    }
    */
}
