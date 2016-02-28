<?php
use yii\db\Schema;
use yii\db\Migration;

class m130524_225342_setting extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%setting}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'value' => Schema::TYPE_TEXT . ' NOT NULL',
            'label' => Schema::TYPE_STRING . '(64)',
        ], $tableOptions);
        
        $this->batchInsert('{{%setting}}', ['name', 'value', 'label'], [
        		['token', '', 'Twitter Token'],
        		['tokenSecret', '', 'Twitter Token Secret'],
        		['consumerKey', '', 'Twitter Consumer Key'],
        		['consumerSecret', '', 'Twitter Consumer Secret'],
        		['tweetArea', '50km', 'Tweet Area']
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%setting}}');
    }
}