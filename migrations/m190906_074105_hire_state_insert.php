<?php

use yii\db\Migration;

/**
 * Class m190906_074105_hire_state_insert
 */
class m190906_074105_hire_state_insert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("INSERT INTO `hire_state` (`id`, `name`) VALUES ('1', 'Бронь');
INSERT INTO `hire_state` (`id`, `name`) VALUES ('2', 'Просрочен');
INSERT INTO `hire_state` (`id`, `name`) VALUES ('3', 'Закрыт');
INSERT INTO `hire_state` (`id`, `name`) VALUES ('4', 'В прокате');
INSERT INTO `hire_state` (`id`, `name`) VALUES ('5', 'Долг');
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190906_074105_hire_state_insert cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190906_074105_hire_state_insert cannot be reverted.\n";

        return false;
    }
    */
}
