<?php

use yii\db\Migration;

/**
 * Class m191028_134048_fix_eq
 */
class m191028_134048_fix_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` ADD COLUMN `confirmed` VARCHAR(45) NULL DEFAULT '1' COMMENT 'Флаг подтверждения информации об инструменте, 0 - нет,1-да' AFTER `dop_status`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191028_134048_fix_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191028_134048_fix_eq cannot be reverted.\n";

        return false;
    }
    */
}
