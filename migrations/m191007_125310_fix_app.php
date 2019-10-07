<?php

use yii\db\Migration;

/**
 * Class m191007_125310_fix_app
 */
class m191007_125310_fix_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `applications_field` (`id`, `code`, `name`) VALUES ('10', 'branch', 'Филиал');
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191007_125310_fix_app cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191007_125310_fix_app cannot be reverted.\n";

        return false;
    }
    */
}
