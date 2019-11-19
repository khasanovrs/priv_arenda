<?php

use yii\db\Migration;

/**
 * Class m191119_051520_hire_lesa_show_field
 */
class m191119_051520_hire_lesa_show_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `hire_lesa_show_field` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `hire_field_id` INT(11) NOT NULL COMMENT 'код поля',
  PRIMARY KEY (`id`));
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191119_051520_hire_lesa_show_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191119_051520_hire_lesa_show_field cannot be reverted.\n";

        return false;
    }
    */
}
