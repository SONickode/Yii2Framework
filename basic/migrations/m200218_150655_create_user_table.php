<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m200218_150655_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(64)->notNull(),
            'email' => $this->string(64)->notNull(),
            'displayname' => $this->string(64)->notNull(),
            'password' => $this->string(64)->notNull(),
            'resetKey' => $this->string(64)->notNull(),
            'authKey' => $this->string(64)->notNull(),
            'privileges' => $this->string(64)->notNull()->defaultValue('inactive')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
