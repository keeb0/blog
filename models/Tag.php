<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $name
 *
 * @property ArticleTag[] $articleTags
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[ArticleTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['tag_id' => 'id']);
    }

    public static function getAll()
    {
        return self::find()
            ->orderBy('name')
            ->all();
    }

    public function getAllNames()
    {
        return ArrayHelper::map(self::getAll(), 'id', 'name');
    }

    public function createTag($name)
    {
        $this->name = $name;
        return $this->save() ? $this->id : false;
    }

    public function exists($value)
    {
        return Tag::find()->where(['name' => $value])->one();
    }

    public function getArticlesByTag($articlesAmount)
    {
        $query = $this->getArticles();

        $pagination = new Pagination([
            'defaultPageSize' => $articlesAmount,
            'totalCount' => $query->count(),
        ]);

        $data['articles'] = $query->orderBy('created DESC')
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->all();

        $data['pagination'] = $pagination;
        return $data;
    }

    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])
            ->viaTable('article_tag', ['tag_id' => 'id']);
    }
}
