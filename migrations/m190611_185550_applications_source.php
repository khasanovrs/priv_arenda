<?php

use yii\db\Migration;

/**
 * Class m190611_185550_applications_source
 */
class m190611_185550_applications_source extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO `applications_source` (`id`, `name`) VALUES ('1', 'Сайт');");
        $this->execute("INSERT INTO `applications_source` (`id`, `name`) VALUES ('2', 'Соц. сети');");
        $this->execute("INSERT INTO `applications_source` (`id`, `name`) VALUES ('3', 'Звонки');");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190611_185550_applications_source cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_185550_applications_source cannot be reverted.\n";

        return false;
    }
    */
}
