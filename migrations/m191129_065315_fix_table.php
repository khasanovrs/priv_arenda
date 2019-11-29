<?php

use yii\db\Migration;

/**
 * Class m191129_065315_fix_table
 */
class m191129_065315_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `applications_demand` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `client_id` INT(11) NOT NULL DEFAULT '0',
  `source_id` INT(11) NOT NULL,
  `discount_id` INT(11) NOT NULL,
  `delivery_id` INT(11) NOT NULL,
  `type_lease_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `branch_id` INT(11) NOT NULL,
  `comment` VARCHAR(500) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `rent_start` DATETIME NULL DEFAULT NULL,
  `rent_end` DATETIME NULL DEFAULT NULL,
  `date_create` DATETIME NULL DEFAULT NULL,
  `is_not_active` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL DEFAULT '0',
  `eq_id` VARCHAR(45) NULL,
  `delivery_sum` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191129_065315_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191129_065315_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
