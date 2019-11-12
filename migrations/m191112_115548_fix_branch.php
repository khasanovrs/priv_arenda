<?php

use yii\db\Migration;

/**
 * Class m191112_115548_fix_branch
 */
class m191112_115548_fix_branch extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `branch` (`id`, `name`, `region`, `time_diff`) VALUES ('18', 'Севастополь', '99', '0');");
        $this->execute("INSERT INTO `stock` (`id`, `id_branch`, `name`, `date_create`, `date_update`) VALUES ('18', '18', 'Севастополь', '2019-09-14 12:09:44', '2019-09-14 12:09:44');
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191112_115548_fix_branch cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191112_115548_fix_branch cannot be reverted.\n";

        return false;
    }
    */
}
