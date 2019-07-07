<?php

use yii\db\Migration;

/**
 * Class m190707_132919_fix_finance
 */
class m190707_132919_fix_finance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `finance_show_field` 
DROP FOREIGN KEY `fk_finance_show_field_2`;
ALTER TABLE `finance_show_field` 
CHANGE COLUMN `applications_field_id` `finance_field_id` INT(11) NOT NULL COMMENT 'код поля' ;
ALTER TABLE `finance_show_field` 
ADD CONSTRAINT `fk_finance_show_field_2`
  FOREIGN KEY (`finance_field_id`)
  REFERENCES `equipments` (`id`);
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190707_132919_fix_finance cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190707_132919_fix_finance cannot be reverted.\n";

        return false;
    }
    */
}
