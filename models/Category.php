<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 *
 * @property Article[] $articles
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
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
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    public function getArticlesByCategory($articlesAmount)
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
}
