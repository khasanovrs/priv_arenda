<?php

use yii\db\Migration;

/**
 * Class m191114_112319_fix_eq
 */
class m191114_112319_fix_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments` ADD INDEX `index8` (`is_not_active` ASC);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191114_112319_fix_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191114_112319_fix_eq cannot be reverted.\n";

        return false;
    }
    */
}
