<?php

use yii\db\Migration;

/**
 * Class m190906_072238_hire_state
 */
class m190906_072238_hire_state extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `hire_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190906_072238_hire_state cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190906_072238_hire_state cannot be reverted.\n";

        return false;
    }
    */
}
