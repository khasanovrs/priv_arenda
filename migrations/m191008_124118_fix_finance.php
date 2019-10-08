<?php

use yii\db\Migration;

/**
 * Class m191008_124118_fix_finance
 */
class m191008_124118_fix_finance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `finance` 
DROP FOREIGN KEY `fin_2`;
ALTER TABLE `finance` 
DROP COLUMN `payer_id`,
DROP INDEX `fin_2_idx` ;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_124118_fix_finance cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_124118_fix_finance cannot be reverted.\n";

        return false;
    }
    */
}
