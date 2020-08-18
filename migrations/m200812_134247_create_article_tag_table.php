<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article_tag}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%article}}`
 * - `{{%tag}}`
 */
class m200812_134247_create_article_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article_tag}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `article_id`
        $this->createIndex(
            '{{%idx-article_tag-article_id}}',
            '{{%article_tag}}',
            'article_id'
        );

        // add foreign key for table `{{%article}}`
        $this->addForeignKey(
            '{{%fk-article_tag-article_id}}',
            '{{%article_tag}}',
            'article_id',
            '{{%article}}',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            '{{%idx-article_tag-tag_id}}',
            '{{%article_tag}}',
            'tag_id'
        );

        // add foreign key for table `{{%tag}}`
        $this->addForeignKey(
            '{{%fk-article_tag-tag_id}}',
            '{{%article_tag}}',
            'tag_id',
            '{{%tag}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%article}}`
        $this->dropForeignKey(
            '{{%fk-article_tag-article_id}}',
            '{{%article_tag}}'
        );

        // drops index for column `article_id`
        $this->dropIndex(
            '{{%idx-article_tag-article_id}}',
            '{{%article_tag}}'
        );

        // drops foreign key for table `{{%tag}}`
        $this->dropForeignKey(
            '{{%fk-article_tag-tag_id}}',
            '{{%article_tag}}'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            '{{%idx-article_tag-tag_id}}',
            '{{%article_tag}}'
        );

        $this->dropTable('{{%article_tag}}');
    }
}
