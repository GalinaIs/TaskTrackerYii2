<?php

namespace common\models\tables;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $img_path
 * @property int $user_id
 * @property int $task_id
 *
 * @property Users $user
 * @property TaskComment[] $taskComments
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'user_id'], 'required'],
            [['content'], 'string'],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 50],
            //[['img_path'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['img_path'], 'file', 'extensions' => 'png, jpg']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('taskComment', 'title'),
            'content' => Yii::t('taskComment', 'content'),
            'img_path' => Yii::t('taskComment', 'img_path'),
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskComments()
    {
        return $this->hasMany(TaskComment::className(), ['comment_id' => 'id']);
    }

    public function upload() {
        $fileName = $this->img_path->getBaseName() . '.' . $this->img_path->getExtension();
        $filePath = \Yii::getAlias("@img/{$fileName}");
        $this->img_path->saveAs($filePath);
        Image::thumbnail($filePath, 100, 100)
            ->save(Yii::getAlias("@img/small/{$fileName}"));

        $this->img_path = $fileName;
    }
}
