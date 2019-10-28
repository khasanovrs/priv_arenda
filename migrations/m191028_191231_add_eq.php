<?php

use yii\db\Migration;

/**
 * Class m191028_191231_add_eq
 */
class m191028_191231_add_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `equipments_status` (`id`, `name`, `color`) VALUES ('7', 'Спрос', '#ffffff');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191028_191231_add_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191028_191231_add_eq cannot be reverted.\n";

        return false;
    }
    */
}
