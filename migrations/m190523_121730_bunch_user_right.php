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
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `right_id` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `fk_bunch_user_right_1_idx` (`right_id`),
            KEY `fk_bunch_user_right_2_idx` (`user_id`),
            CONSTRAINT `fk_bunch_user_right_1` FOREIGN KEY (`right_id`) REFERENCES `users_rights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `fk_bunch_user_right_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
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
