<?php

use yii\db\Migration;

/**
 * Class m191021_194202_fix_app_eq
 */
class m191021_194202_fix_app_eq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('18', 'delivery_sum', 'Сумма доставки');
INSERT INTO `hire_field` (`id`, `code`, `name`) VALUES ('19', 'delivery_suь_paid', 'Сумма доставки оплачено');
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191021_194202_fix_app_eq cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191021_194202_fix_app_eq cannot be reverted.\n";

        return false;
    }
    */
}
