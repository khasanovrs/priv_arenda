<?php

use yii\db\Migration;

/**
 * Class m191002_153124_fix_table
 */
class m191002_153124_fix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("ALTER TABLE `equipments_type` 
ADD CONSTRAINT `1`
  FOREIGN KEY (`category_id`)
  REFERENCES `equipments_category` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191002_153124_fix_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191002_153124_fix_table cannot be reverted.\n";

        return false;
    }
    */
}
