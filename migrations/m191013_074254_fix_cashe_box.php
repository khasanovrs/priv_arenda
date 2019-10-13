<?php

use yii\db\Migration;

/**
 * Class m191013_074254_fix_cashe_box
 */
class m191013_074254_fix_cashe_box extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` 
DROP COLUMN `sale`,
DROP INDEX `ff_idx` ;
;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191013_074254_fix_cashe_box cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191013_074254_fix_cashe_box cannot be reverted.\n";

        return false;
    }
    */
}
