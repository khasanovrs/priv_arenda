<?php

use yii\db\Migration;

/**
 * Class m191112_115434_fix_branch
 */
class m191112_115434_fix_branch extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("UPDATE `stock` SET `id_branch`='13' WHERE `id`='13';");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191112_115434_fix_branch cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191112_115434_fix_branch cannot be reverted.\n";

        return false;
    }
    */
}
