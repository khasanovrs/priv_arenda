<?php

use yii\db\Migration;

/**
 * Class m190712_100721_hire_status_insert
 */
class m190712_100721_hire_status_insert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `hire_status` (`id`, `name`, `color`) VALUES ('1', 'В прокате', '#ffffff');
INSERT INTO `hire_status` (`id`, `name`, `color`) VALUES ('2', 'Просрочен', '#ffffff');
INSERT INTO `hire_status` (`id`, `name`, `color`) VALUES ('3', 'Бронь', '#ffffff');
INSERT INTO `hire_status` (`id`, `name`, `color`) VALUES ('4', 'Закрыт', '#ffffff');
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190712_100721_hire_status_insert cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190712_100721_hire_status_insert cannot be reverted.\n";

        return false;
    }
    */
}
