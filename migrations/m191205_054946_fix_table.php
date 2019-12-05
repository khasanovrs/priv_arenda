<?php

use yii\db\Migration;

/**
 * Class m191205_054946_fix_table
 */
class m191205_054946_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `equipments_demand` 
DROP FOREIGN KEY `fk_equipments_demand_1`;
ALTER TABLE `equipments_demand` 
CHANGE COLUMN `stock_id` `confirmed` VARCHAR(150) NOT NULL COMMENT '0- не подтвержден,1-подтвержден' ,
DROP INDEX `fk_equipments_demand_1_idx` ;
;

");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191205_054946_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191205_054946_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
