<?php

use yii\db\Migration;

/**
 * Class m200813_084415_add_new_table_vacation
 */
class m200813_084415_add_new_table_vacation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vacation', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'from_date' => $this->integer()->notNull(),
            'to_date' => $this->integer()->notNull(),
            'is_approved' => $this->boolean()->defaultValue(false),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->addForeignKey('fk_vacation_user', 'vacation', 'user_id', 'user', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_vacation_user', 'vacation');

        $this->dropTable('vacation');
    }
}
