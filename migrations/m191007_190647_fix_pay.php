<?php

use yii\db\Migration;

/**
 * Class m191007_190647_fix_pay
 */
class m191007_190647_fix_pay extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `application_pay` 
ADD COLUMN `client_id` INT(11) NOT NULL AFTER `sum`,
ADD INDEX `fk_application_pay_3_idx1` (`client_id` ASC) VISIBLE;
;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191007_190647_fix_pay cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191007_190647_fix_pay cannot be reverted.\n";

        return false;
    }
    */
}
