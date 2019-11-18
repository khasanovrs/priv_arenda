<?php

use yii\db\Migration;

/**
 * Class m191118_104938_fix_field
 */
class m191118_104938_fix_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("DELETE FROM `equipments_field` WHERE `id`='21';");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191118_104938_fix_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191118_104938_fix_field cannot be reverted.\n";

        return false;
    }
    */
}
