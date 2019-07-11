<?php

use yii\db\Migration;

/**
 * Class m190711_062712_fix_source
 */
class m190711_062712_fix_source extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `applications_source` RENAME TO  `source` ;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190711_062712_fix_source cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190711_062712_fix_source cannot be reverted.\n";

        return false;
    }
    */
}
