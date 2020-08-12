<?php

use common\models\User;
use yii\db\Migration;

class m140703_122950_department extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%department}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'settings' => $this->json()
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable('{{%department}}');
    }
}
