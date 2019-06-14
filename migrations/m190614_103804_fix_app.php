<?php

use yii\db\Migration;

/**
 * Class m190614_103804_fix_app
 */
class m190614_103804_fix_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
            DROP FOREIGN KEY `fk_applications_3`;
            ALTER TABLE `applications` 
            CHANGE COLUMN `stock_id` `branch_id` INT(11) NOT NULL ,
            ADD INDEX `fk_applications_3_idx` (`branch_id` ASC),
            DROP INDEX `fk_applications_3_idx` ;
            ALTER TABLE `applications` 
            ADD CONSTRAINT `fk_applications_3`
            FOREIGN KEY (`branch_id`)
            REFERENCES `branch` (`id`)
            ON DELETE NO ACTION
ON UPDATE NO ACTION;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190614_103804_fix_app cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190614_103804_fix_app cannot be reverted.\n";

        return false;
    }
    */
}
