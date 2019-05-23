<?php

use yii\db\Migration;

/**
 * Class m190523_121730_bunch_user_right
 */
class m190523_121730_bunch_user_right extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `bunch_user_right` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `user_id` INT(11) NOT NULL,
            `right_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`),
            INDEX `fk_bunch_user_right_1_idx` (`right_id` ASC),
            INDEX `fk_bunch_user_right_2_idx` (`user_id` ASC),
            CONSTRAINT `fk_bunch_user_right_1`
            FOREIGN KEY (`right_id`)
            REFERENCES `users_rights` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
            CONSTRAINT `fk_bunch_user_right_2`
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
        echo "m190523_121730_bunch_user_right cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190523_121730_bunch_user_right cannot be reverted.\n";

        return false;
    }
    */
}
