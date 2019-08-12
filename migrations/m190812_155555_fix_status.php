<?php

use yii\db\Migration;

/**
 * Class m190812_155555_fix_status
 */
class m190812_155555_fix_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications_status` CHANGE COLUMN `color` `color` VARCHAR(45) NOT NULL DEFAULT '#fff' ;");
        $this->execute("ALTER TABLE `client_status` CHANGE COLUMN `color` `color` VARCHAR(45) NOT NULL DEFAULT '#fff' ;");
        $this->execute("ALTER TABLE `equipments_status` CHANGE COLUMN `color` `color` VARCHAR(45) NOT NULL DEFAULT '#fff' ;");
        $this->execute("ALTER TABLE `hire_status` CHANGE COLUMN `color` `color` VARCHAR(45) NOT NULL DEFAULT '#fff' ;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190812_155555_fix_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190812_155555_fix_status cannot be reverted.\n";

        return false;
    }
    */
}
