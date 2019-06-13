<?php

use yii\db\Migration;

/**
 * Class m190611_185219_applications_status
 */
class m190611_185219_applications_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `applications_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190611_185219_applications_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_185219_applications_status cannot be reverted.\n";

        return false;
    }
    */
}
