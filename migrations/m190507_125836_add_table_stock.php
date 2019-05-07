<?php

use yii\db\Migration;

/**
 * Class m190507_125836_add_table_stock
 */
class m190507_125836_add_table_stock extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `stock` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `id_branch` int(11) DEFAULT NULL,
      `name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
      `date_create` datetime DEFAULT NULL COMMENT 'дата создания записи',
      `date_update` datetime DEFAULT NULL COMMENT 'тип роли',
      PRIMARY KEY (`id`),
      KEY `fk_stock_1_idx` (`id_branch`),
      CONSTRAINT `fk_stock_1` FOREIGN KEY (`id_branch`) REFERENCES `branch` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
    ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190507_125836_add_table_stock cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_125836_add_table_stock cannot be reverted.\n";

        return false;
    }
    */
}
