<?php

use yii\db\Migration;

/**
 * Class m191021_080333_fix_hire
 */
class m191021_080333_fix_hire extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('17', 'id_dog', 'Номер договора');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191021_080333_fix_hire cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191021_080333_fix_hire cannot be reverted.\n";

        return false;
    }
    */
}
