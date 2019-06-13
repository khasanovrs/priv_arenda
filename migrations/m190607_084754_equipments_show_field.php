<?php

use yii\db\Migration;

/**
 * Class m190607_084754_equipments_show_field
 */
class m190607_084754_equipments_show_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `equipments_show_field` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `equipments_field_id` int(11) NOT NULL COMMENT 'код поля',
          PRIMARY KEY (`id`),
          KEY `fk_equipments_show_field_1_idx` (`equipments_field_id`),
          KEY `fk_equipments_show_field_2_idx` (`user_id`),
          CONSTRAINT `fk_equipments_show_field_1` FOREIGN KEY (`equipments_field_id`) REFERENCES `equipments_field` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `fk_equipments_show_field_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190607_084754_equipments_show_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190607_084754_equipments_show_field cannot be reverted.\n";

        return false;
    }
    */
}
