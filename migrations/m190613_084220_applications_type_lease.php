<?php

use yii\db\Migration;

/**
 * Class m190613_084220_applications_type_lease
 */
class m190613_084220_applications_type_lease extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `applications_type_lease` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(150) CHARACTER SET utf8 NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_084220_applications_type_lease cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_084220_applications_type_lease cannot be reverted.\n";

        return false;
    }
    */
}
