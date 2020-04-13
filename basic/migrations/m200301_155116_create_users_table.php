<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m200301_155116_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
        {
            $this->createTable('{{%users}}', [
                
                'id' => $this->integer()->notNull(),
                'username' => $this->string(64),
                'email' => $this->string(64),
                'displayname' => $this->string(64),
                'password' => $this->string(64),
                'resetKey' => $this->string(64),
            ]);
            
            $this->addForeignKey('fk-users-id-user-id', 'users', 'id', 'user', 'id', 'CASCADE', 'CASCADE');
            
            // $this->createIndex(
            //     'idx-users-id',
            //     'users',
            //     'id'
            // );
            
            
            // $this->addForeignKey(
            //     'fk-users-id-user-id',
            //     'users',
            //     'id',
            //     'user',
            //     'id',
            //     'CASCADE'
            // );


            // $this->createIndex(
            //     'idx-user-username',
            //     'user',
            //     'username'
            // );
            // $this->createIndex(
            //     'idx-users-username',
            //     'users',
            //     'username'
            // );
            
            // $this->addForeignKey(
            //     'fk-users-username-user-username',
            //     'users',
            //     'username',
            //     'user',
            //     'username',
            //     'CASCADE'
            // );


            // $this->createIndex(
            //     'idx-user-email',
            //     'user',
            //     'email'
            // );
            // $this->createIndex(
            //     'idx-users-email',
            //     'users',
            //     'email'
            // );
            // $this->addForeignKey(
            //     'fk-users-email-user-email',
            //     'users',
            //     'email',
            //     'user',
            //     'email',
            //     'CASCADE'
            // );


            // $this->createIndex(
            //     'idx-user-displayname',
            //     'user',
            //     'displayname'
            // );
            // $this->createIndex(
            //     'idx-users-displayname',
            //     'users',
            //     'displayname'
            // );
            // $this->addForeignKey(
            //     'fk-users-displayname-user-displayname',
            //     'users',
            //     'displayname',
            //     'user',
            //     'displayname',
            //     'CASCADE'
            // );


            // $this->createIndex(
            //     'idx-user-password',
            //     'user',
            //     'password'
            // );
            // $this->createIndex(
            //     'idx-users-password',
            //     'users',
            //     'password'
            // );
            // $this->addForeignKey(
            //     'fk-users-password-user-password',
            //     'users',
            //     'password',
            //     'user',
            //     'password',
            //     'CASCADE'
            // );


            // $this->createIndex(
            //     'idx-user-resetKey',
            //     'user',
            //     'resetKey'
            // );
            // $this->createIndex(
            //     'idx-users-resetKey',
            //     'users',
            //     'resetKey'
            // );
            // $this->addForeignKey(
            //     'fk-users-resetKey-user-resetKey',
            //     'users',
            //     'resetKey',
            //     'user',
            //     'resetKey',
            //     'CASCADE'
            // );
        }
    
        /**
         * {@inheritdoc}
         */
        public function safeDown()
        {
            $this->dropTable('{{%users}}');
        }
}
