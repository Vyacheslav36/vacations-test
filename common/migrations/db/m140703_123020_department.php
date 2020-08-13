<?php

use common\models\User;
use yii\db\Migration;

class m140703_123020_department extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%department}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'manager_id' => $this->integer(),
            'settings' => $this->json()
        ]);

        $this->addForeignKey('fk_department_user', '{{%department}}', 'manager_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_department_user', '{{%department}}');

        $this->dropTable('{{%department}}');
    }
}
