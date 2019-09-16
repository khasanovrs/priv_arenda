<?php

use yii\db\Migration;

/**
 * Class m190915_112929_fix_app_pay
 */
class m190915_112929_fix_app_pay extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `application_pay` 
ADD COLUMN `cashBox` int(10) NOT NULL DEFAULT '1' AFTER `date_create`,
ADD INDEX `fk_application_pay_3_idx` (`cashBox` ASC) VISIBLE;
ALTER TABLE `application_pay` 
ADD CONSTRAINT `fk_application_pay_3`
  FOREIGN KEY (`cashBox`)
  REFERENCES `finance_cashbox` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190915_112929_fix_app_pay cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190915_112929_fix_app_pay cannot be reverted.\n";

        return false;
    }
    */
}
