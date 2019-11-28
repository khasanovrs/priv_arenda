<?php

use yii\db\Migration;

/**
 * Class m191128_130905_fix_table
 */
class m191128_130905_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("DELETE FROM `equipments_status` WHERE `id`='7';
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191128_130905_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191128_130905_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
