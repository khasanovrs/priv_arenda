<?php

use yii\db\Migration;

/**
 * Class m190506_103252_add_users_role
 */
class m190506_103252_add_users_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `users_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
          ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190507_072252_add_users_role cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_072252_add_users_role cannot be reverted.\n";

        return false;
    }
    */
}
