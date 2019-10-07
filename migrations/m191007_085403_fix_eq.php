<?php

use yii\db\Migration;

/**
 * Class m191007_085403_fix_eq
 */
class m191007_085403_fix_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` 
ADD COLUMN `is_not_active` VARCHAR(45) NOT NULL DEFAULT 0 AFTER `photo_alias`;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191007_085403_fix_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191007_085403_fix_eq cannot be reverted.\n";

        return false;
    }
    */
}
