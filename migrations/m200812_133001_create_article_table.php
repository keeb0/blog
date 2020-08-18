<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%category}}`
 */
class m200812_133001_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'image' => $this->string(),
            'viewed' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->smallinteger()->notNull()->defaultValue(0),
            'author_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'created' => 'datetime DEFAULT NOW()',
            'modified' => 'datetime ON UPDATE NOW()',
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-article-author_id}}',
            '{{%article}}',
            'author_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-article-author_id}}',
            '{{%article}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-article-category_id}}',
            '{{%article}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-article-category_id}}',
            '{{%article}}',
            'category_id',
            '{{%category}}',
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
            '{{%fk-article-author_id}}',
            '{{%article}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-article-author_id}}',
            '{{%article}}'
        );

        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-article-category_id}}',
            '{{%article}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-article-category_id}}',
            '{{%article}}'
        );

        $this->dropTable('{{%article}}');
    }
}
