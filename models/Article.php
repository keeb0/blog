<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use app\models\ArticleTag;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $image
 * @property int $viewed
 * @property int $status
 * @property int $author_id
 * @property int $category_id
 * @property string|null $created
 * @property string|null $modified
 *
 * @property User $author
 * @property Category $category
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    public $userTags;
    public $updatedTags;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'category_id'], 'required'],
            // [['content'], 'string'],
            [['category_id'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'content' => 'Содержание',
            'image' => 'Фото',
            'viewed' => 'Просмотров',
            'status' => 'Статус',
            'author_id' => 'Автор',
            'category_id' => 'Категория',
            'created' => 'Дата публикации',
            'modified' => 'Дата редактирования',
            'userTags' => 'Ваши теги (ввод через запятую)',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[ArticleTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }

    ///==========================================================================

    public static function getOnMain($articlesAmount)
    {
        $query = self::find();

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

    public static function getPopular($amount)
    {
        return self::find()->orderBy('viewed DESC')->limit($amount)->all();
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->created);
    }

    public static function getImagesFolder()
    {
        return Yii::getAlias('@web') . 'images/article/';
    }

    public function getImage()
    {
        return !empty($this->image) ? '/images/article/' . $this->image : null;
    }

    public function getImageForSb()
    {
        $image = $this->getImage();
        return $image ? $image : '/images/article/default-article.png';
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id'])
            ->orderBy('name');
    }

    public function updateArticle()
    {
        $this->deleteAllTags();
        
        $allTags = $this->setAllTags();

        $this->saveTagRelations($allTags);

        $this->save();
    }

    public function createArticle()
    {
        $this->author_id = Yii::$app->user->identity->id;
        
        if ($this->save()) {
            $allTags = $this->setAllTags();
            $this->saveTagRelations($allTags);

            return $this->id;
        }
    }

    private function saveTagRelations($allTags)
    {
        foreach ($allTags as $value) {
            $tagRelation = new ArticleTag();
            $tagRelation->tag_id = $value;
            $tagRelation->article_id = $this->id;

            $tagRelation->save();
        }
    }

    private function deleteAllTags()
    {
        while ($tagRelation = ArticleTag::find()->where(['article_id' => $this->id])->one()) {
            $tagRelation->delete();
        }
    }

    private function saveNewTags()
    {
        if ($userTags = explode(',', $this->userTags)) {
            foreach ($userTags as $value) {
                $tag = new Tag();

                if (!($tag->exists($value))) {
                    $newTags[] = $tag->createTag($value);
                }
            }
            return isset($newTags) ? $newTags : false;
        }
    }

    private function setAllTags()
    {
        $allTags = [];
        if ($newTags = $this->saveNewTags()) {
            foreach ($newTags as $value) {
                $allTags[] = $value;
            }
        }

        if (!empty($this->updatedTags)) {
            foreach ($this->updatedTags as $key => $value) {
                $allTags[] = $value;
            }
        }

        return $allTags;
    }

    public function riseViews()
    {
        $this->viewed++;
        $this->save(false);
    }
}
