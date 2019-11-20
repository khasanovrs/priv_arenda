<?php

use yii\db\Migration;

/**
 * Class m191120_055606_fix_field
 */
class m191120_055606_fix_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
          INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('26', 'month_sum', 'Цена за месяц');
          INSERT INTO `hire_lesa_field` (`id`, `code`, `name`) VALUES ('27', 'square', 'Плошадь');
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191120_055606_fix_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191120_055606_fix_field cannot be reverted.\n";

        return false;
    }
    */
}
