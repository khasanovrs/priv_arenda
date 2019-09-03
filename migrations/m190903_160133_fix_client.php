<?php

use yii\db\Migration;

/**
 * Class m190903_160133_fix_client
 */
class m190903_160133_fix_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `clients_info` 
DROP COLUMN `address_passport`,
DROP COLUMN `date_passport`,
DROP COLUMN `where_passport`,
DROP COLUMN `schet`,
DROP COLUMN `bic`,
DROP COLUMN `ogrn`,
DROP COLUMN `occupation`,
DROP COLUMN `address`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190903_160133_fix_client cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190903_160133_fix_client cannot be reverted.\n";

        return false;
    }
    */
}
