<?php

use yii\db\Migration;

/**
 * Class m190710_074711_fix_finance
 */
class m190710_074711_fix_finance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `finance_field` (`id`, `code`, `name`) VALUES ('9', 'branch', 'Филиал');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190710_074711_fix_finance cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190710_074711_fix_finance cannot be reverted.\n";

        return false;
    }
    */
}
