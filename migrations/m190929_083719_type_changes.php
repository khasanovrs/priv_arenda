<?php

use yii\db\Migration;

/**
 * Class m190929_083719_type_changes
 */
class m190929_083719_type_changes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `type_changes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id`));");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190929_083719_type_changes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190929_083719_type_changes cannot be reverted.\n";

        return false;
    }
    */
}
