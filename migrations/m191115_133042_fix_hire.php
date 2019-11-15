<?php

use yii\db\Migration;

/**
 * Class m191115_133042_fix_hire
 */
class m191115_133042_fix_hire extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('19', 'count', 'Общее количество');
INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('20', 'count_hire', 'В прокате');
INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('21', 'count_repairs', 'На ремонте');
INSERT INTO `equipments_field` (`id`, `code`, `name`) VALUES ('22', 'count_left', 'Осталось');

");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191115_133042_fix_hire cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191115_133042_fix_hire cannot be reverted.\n";

        return false;
    }
    */
}
