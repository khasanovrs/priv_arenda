<?php

use yii\db\Migration;

/**
 * Class m191128_135025_fix_table
 */
class m191128_135025_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("INSERT INTO `equipments_demand_field` (`id`, `code`, `name`) VALUES ('3', 'count_demand', 'Количество запросов');
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191128_135025_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191128_135025_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
