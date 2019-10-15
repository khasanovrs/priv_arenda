<?php

use yii\db\Migration;

/**
 * Class m191015_181533_fix_add_hire_field
 */
class m191015_181533_fix_add_hire_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("DELETE FROM `hire_field` WHERE (`id` = '1');
DELETE FROM `hire_field` WHERE (`id` = '2');
DELETE FROM `hire_field` WHERE (`id` = '4');
DELETE FROM `hire_field` WHERE (`id` = '5');
DELETE FROM `hire_field` WHERE (`id` = '6');
DELETE FROM `hire_field` WHERE (`id` = '7');
DELETE FROM `hire_field` WHERE (`id` = '8');
DELETE FROM `hire_field` WHERE (`id` = '9');
DELETE FROM `hire_field` WHERE (`id` = '10');
DELETE FROM `hire_field` WHERE (`id` = '11');
DELETE FROM `hire_field` WHERE (`id` = '12');
DELETE FROM `hire_field` WHERE (`id` = '13');
DELETE FROM `hire_field` WHERE (`id` = '14');
DELETE FROM `hire_field` WHERE (`id` = '15');
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191015_181533_fix_add_hire_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191015_181533_fix_add_hire_field cannot be reverted.\n";

        return false;
    }
    */
}
