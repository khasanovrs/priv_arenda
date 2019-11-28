<?php

use yii\db\Migration;

/**
 * Class m191128_132558_fix_table
 */
class m191128_132558_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `equipments_demand_field` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `name` VARCHAR(150) CHARACTER SET 'utf8' NOT NULL COMMENT 'наименование поля',
  PRIMARY KEY (`id`));
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191128_132558_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191128_132558_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
