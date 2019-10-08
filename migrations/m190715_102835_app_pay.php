<?php

use yii\db\Migration;

/**
 * Class m190715_102835_app_pay
 */
class m190715_102835_app_pay extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `application_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_equipment_id` INT NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_create` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190715_102835_app_pay cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190715_102835_app_pay cannot be reverted.\n";

        return false;
    }
    */
}
