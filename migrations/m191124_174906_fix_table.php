<?php

use yii\db\Migration;

/**
 * Class m191124_174906_fix_table
 */
class m191124_174906_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
ADD COLUMN `equipments_status` INT(11) NOT NULL AFTER `hire_state_id`,
ADD INDEX `fk_applications_7_idx1` (`equipments_status` ASC);
;

");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191124_174906_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191124_174906_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
