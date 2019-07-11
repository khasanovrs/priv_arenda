<?php

use yii\db\Migration;

/**
 * Class m190711_062837_fix_source_client
 */
class m190711_062837_fix_source_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `clients_info` 
DROP FOREIGN KEY `fk_client_info_2`;
ALTER TABLE `clients_info` 
ADD INDEX `fk_client_info_2_idx` (`source` ASC),
DROP INDEX `fk_client_info_2_idx` ;
ALTER TABLE `clients_info` 
ADD CONSTRAINT `fk_client_info_2`
  FOREIGN KEY (`source`)
  REFERENCES `source` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190711_062837_fix_source_client cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190711_062837_fix_source_client cannot be reverted.\n";

        return false;
    }
    */
}
