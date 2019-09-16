<?php

use yii\db\Migration;

/**
 * Class m190916_145944_fix_table
 */
class m190916_145944_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `extension` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date_create` DATETIME NOT NULL,
  `count` VARCHAR(45) NOT NULL,
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `rty_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `rty`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190916_145944_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190916_145944_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
