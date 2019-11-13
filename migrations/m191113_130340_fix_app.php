<?php

use yii\db\Migration;

/**
 * Class m191113_130340_fix_app
 */
class m191113_130340_fix_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `applications` 
ADD INDEX `fk_applications_4_idx` (`client_id` ASC);
ALTER TABLE `applications` 
ADD CONSTRAINT `fk_applications_4`
  FOREIGN KEY (`client_id`)
  REFERENCES `clients` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191113_130340_fix_app cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191113_130340_fix_app cannot be reverted.\n";

        return false;
    }
    */
}
