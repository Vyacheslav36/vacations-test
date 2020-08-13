<?php

use common\models\User;
use yii\db\Migration;

class m140703_123030_user_profile extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->primaryKey(),
            'department_id' => $this->integer(),
            'firstname' => $this->string(),
            'middlename' => $this->string(),
            'lastname' => $this->string(),
            'avatar_path' => $this->string(),
            'avatar_base_url' => $this->string(),
            'locale' => $this->string(32)->notNull(),
            'gender' => $this->smallInteger(1)
        ]);

        $this->addForeignKey('fk_user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_user_profile_department', '{{%user_profile}}', 'department_id', '{{%department}}', 'id', 'cascade', 'cascade');

    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_profile_department', '{{%user_profile}}');
        $this->dropForeignKey('fk_user', '{{%user_profile}}');

        $this->dropTable('{{%user_profile}}');
    }
}
