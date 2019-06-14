<?php

use yii\db\Migration;

/**
 * Class m190614_085521_fix_app
 */
class m190614_085521_fix_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
        ADD COLUMN `stock_id` INT(11) NOT NULL AFTER `user_id`,
        ADD COLUMN `date_create` DATETIME NULL AFTER `total_sum`,
        ADD INDEX `fk_applications_3_idx` (`stock_id` ASC);
        ALTER TABLE `applications` 
        ADD CONSTRAINT `fk_applications_3`
          FOREIGN KEY (`stock_id`)
          REFERENCES `stock` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190614_085521_fix_app cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190614_085521_fix_app cannot be reverted.\n";

        return false;
    }
    */
}
