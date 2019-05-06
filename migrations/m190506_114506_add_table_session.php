<?php

use yii\db\Migration;

/**
 * Class m190506_114506_add_table_session
 */
class m190506_114506_add_table_session extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `session` (
            `id` INT NOT NULL,
            `user_id` INT(11) NOT NULL,
            `session_date` TIMESTAMP NULL DEFAULT NULL COMMENT 'дата создания сессии',
            `session_id` VARCHAR(250) NULL,
            `status` VARCHAR(45) NULL COMMENT 'статус сессии',
            PRIMARY KEY (`id`),
            INDEX `fk_session_1_idx` (`user_id` ASC),
            CONSTRAINT `fk_session_1`
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
        echo "m190506_114506_add_table_session cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190506_114506_add_table_session cannot be reverted.\n";

        return false;
    }
    */
}
