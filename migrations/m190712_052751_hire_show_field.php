<?php

use yii\db\Migration;

/**
 * Class m190712_052751_hire_show_field
 */
class m190712_052751_hire_show_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `hire_show_field` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `hire_field_id` int(11) NOT NULL COMMENT 'код поля',
            PRIMARY KEY (`id`),
            KEY `fk_hire_show_field_1_idx` (`hire_field_id`),
            KEY `fk_hire_show_field_2_idx` (`user_id`),
            CONSTRAINT `fk_hire_show_field_1` FOREIGN KEY (`hire_field_id`) REFERENCES `hire_field` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `fk_hire_show_field_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190712_052751_hire_show_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190712_052751_hire_show_field cannot be reverted.\n";

        return false;
    }
    */
}
