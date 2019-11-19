<?php

use yii\db\Migration;

/**
 * Class m191119_051343_hire_lesa_field
 */
class m191119_051343_hire_lesa_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `hire_lesa_field` (
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
        echo "m191119_051343_hire_lesa_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191119_051343_hire_lesa_field cannot be reverted.\n";

        return false;
    }
    */
}
