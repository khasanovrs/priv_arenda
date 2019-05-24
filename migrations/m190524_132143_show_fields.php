<?php

use yii\db\Migration;

/**
 * Class m190524_132143_show_fields
 */
class m190524_132143_show_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `show_field_client` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `code` VARCHAR(150) NOT NULL COMMENT 'код поля',
          `name` VARCHAR(150) NOT NULL COMMENT 'наименование поля',
          `flag` VARCHAR(5) NOT NULL COMMENT 'флаг отображения, 0-нет,1-да',
          PRIMARY KEY (`id`));
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190524_132143_show_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190524_132143_show_fields cannot be reverted.\n";

        return false;
    }
    */
}
