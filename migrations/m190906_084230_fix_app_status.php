<?php

use yii\db\Migration;

/**
 * Class m190906_084230_fix_app_status
 */
class m190906_084230_fix_app_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("UPDATE `applications_status` SET `name`='Пролет' WHERE `id`='4';
INSERT INTO `applications_status` (`id`, `name`, `color`) VALUES ('5', 'Узнали', '#000000');
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190906_084230_fix_app_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190906_084230_fix_app_status cannot be reverted.\n";

        return false;
    }
    */
}
