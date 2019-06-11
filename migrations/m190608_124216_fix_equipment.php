<?php

use yii\db\Migration;

/**
 * Class m190608_124216_fix_equipment
 */
class m190608_124216_fix_equipment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` 
DROP FOREIGN KEY `fk_equipments_3`,
DROP FOREIGN KEY `fk_equipments_5`;
ALTER TABLE `equipments` 
ADD COLUMN `sale` INT(11) NOT NULL AFTER `status`,
CHANGE COLUMN `status` `status` INT(11) NOT NULL COMMENT 'Доступность' ,
ADD INDEX `ff_idx` (`sale` ASC) VISIBLE;
;
ALTER TABLE `equipments` 
ADD CONSTRAINT `fk_equipments_3`
  FOREIGN KEY (`status`)
  REFERENCES `equipments_status` (`id`),
ADD CONSTRAINT `fk_equipments_5`
  FOREIGN KEY (`status`)
  REFERENCES `equipments_status` (`id`),
ADD CONSTRAINT `ff`
  FOREIGN KEY (`sale`)
  REFERENCES `discount` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190608_124216_fix_equipment cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190608_124216_fix_equipment cannot be reverted.\n";

        return false;
    }
    */
}
