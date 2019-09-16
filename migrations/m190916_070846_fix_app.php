<?php

use yii\db\Migration;

/**
 * Class m190916_070846_fix_app
 */
class m190916_070846_fix_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
DROP FOREIGN KEY `a1`;
ALTER TABLE `applications` 
CHANGE COLUMN `client_id` `client_id` INT(11) NOT NULL DEFAULT 0 ,
DROP INDEX `a1_idx` ;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190916_070846_fix_app cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190916_070846_fix_app cannot be reverted.\n";

        return false;
    }
    */
}
