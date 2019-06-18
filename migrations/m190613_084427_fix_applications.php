<?php

use yii\db\Migration;

/**
 * Class m190613_084427_fix_applications
 */
class m190613_084427_fix_applications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
            ADD COLUMN `type_lease_id` INT(11) NOT NULL AFTER `delivery_id`,
            ADD INDEX `fk_applications_1_idx` (`type_lease_id` ASC);
            ALTER TABLE `applications` 
            ADD CONSTRAINT `fk_applications_1`
            FOREIGN KEY (`type_lease_id`)
            REFERENCES `applications_type_lease` (`id`)
            ON DELETE NO ACTION
ON UPDATE NO ACTION;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_084427_fix_applications cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_084427_fix_applications cannot be reverted.\n";

        return false;
    }
    */
}
