<?php

use yii\db\Migration;

/**
 * Class m190611_182909_applications_show_field
 */
class m190611_182909_applications_show_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE `applications_show_field` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `applications_field_id` int(11) NOT NULL COMMENT 'код поля',
            PRIMARY KEY (`id`),
            KEY `re_idx` (`user_id`),
            KEY `re2_idx` (`applications_field_id`),
            CONSTRAINT `re` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
            CONSTRAINT `re2` FOREIGN KEY (`applications_field_id`) REFERENCES `applications_field` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190611_182909_applications_show_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_182909_applications_show_field cannot be reverted.\n";

        return false;
    }
    */
}
