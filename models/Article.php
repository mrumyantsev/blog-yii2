<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%articles}}".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $date
 * @property string|null $image
 * @property int|null $view_count
 * @property int|null $user_id
 * @property int|null $category_id
 * @property int|null $status
 *
 * @property ArticleTag[] $articleTag
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%articles}}';
    }

    public static function getAll($pageSize = 1)
    {
        $query = static::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        
        return [
            'articles' => $articles,
            'pagination' => $pagination,
        ];
    }

    public static function getPopular()
    {
        return static::find()->orderBy(['view_count' => SORT_DESC])->limit(3)->all();
    }

    public static function getRecent()
    {
        return static::find()->orderBy('date ASC')->limit(4)->all();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'description', 'content'], 'string'],
            [['title'], 'string', 'max' => 255],

            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'view_count' => 'View Count',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
            'status' => 'Status',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        return ($this->image) ? '/uploads/' . $this->image : '/no-image.png';
    }

    /**
     * {@inheritdoc}
     */
    public function saveImage($filename)
    {
        $this->image = $filename;
        return $this->save(false);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteFile($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();

        return parent::beforeDelete();
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function saveCategory($categoryId)
    {
        $category = Category::findOne($categoryId);

        if (!$category) {
            return false;
        }

        $this->link('category', $category);

        return true;
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('articles_tags', ['article_id' => 'id']);
    }

    public function getSelectedTags()
    {
        $selectedTags = $this->getTags()->select('id')->asArray()->all();

        return ArrayHelper::getColumn($selectedTags, 'id');
    }

    public function saveTags($tags)
    {
        if (!is_array($tags)) {
            return;
        }

        $this->deleteCurrentTags();
        
        foreach ($tags as $tagId) {
            $tag = Tag::findOne($tagId);
            $this->link('tags', $tag);
        }
    }
    
    public function deleteCurrentTags()
    {
        ArticleTag::deleteAll(['article_id' => $this->id]);
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->date, 'long');
    }

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['article_id' => 'id']);
    }

    public function getVerifiedComments()
    {
        return $this->getComments()->where(['status' => 1])->all();
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function incrementViewCount()
    {
        $this->view_count++;

        return $this->save(false);
    }

    public function saveWithUserId()
    {
        $this->user_id = Yii::$app->user->id;

        return $this->save(true);
    }

}
