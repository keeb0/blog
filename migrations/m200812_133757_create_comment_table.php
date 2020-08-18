<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%article}}`
 */
class m200812_133757_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string()->notNull(),
            'status' => $this->smallinteger()->notNull()->defaultValue(0),
            'author_id' => $this->integer()->notNull(),
            'article_id' => $this->integer()->notNull(),
            'created' => 'datetime DEFAULT NOW()',
            'modified' => 'datetime ON UPDATE NOW()',
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-comment-author_id}}',
            '{{%comment}}',
            'author_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-comment-author_id}}',
            '{{%comment}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `article_id`
        $this->createIndex(
            '{{%idx-comment-article_id}}',
            '{{%comment}}',
            'article_id'
        );

        // add foreign key for table `{{%article}}`
        $this->addForeignKey(
            '{{%fk-comment-article_id}}',
            '{{%comment}}',
            'article_id',
            '{{%article}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-comment-author_id}}',
            '{{%comment}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-comment-author_id}}',
            '{{%comment}}'
        );

        // drops foreign key for table `{{%article}}`
        $this->dropForeignKey(
            '{{%fk-comment-article_id}}',
            '{{%comment}}'
        );

        // drops index for column `article_id`
        $this->dropIndex(
            '{{%idx-comment-article_id}}',
            '{{%comment}}'
        );

        $this->dropTable('{{%comment}}');
    }
}
