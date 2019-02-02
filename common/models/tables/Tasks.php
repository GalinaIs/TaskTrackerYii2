<?php

namespace common\models\tables;

use Yii;
use common\events\TaskEvent as TaskEvent;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord as ActiveRecord;
use yii\db\AfterSaveEvent;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string $date
 * @property string $description
 * @property int $responsible_id
 * 
 * @property Users $user
 */
class Tasks extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date'], 'required'],
            [['date', 'updated_at', 'created_at'], 'safe'],
            [['description'], 'string'],
            [['responsible_id', 'id_status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'date' => 'Срок',
            'description' => 'Описание',
            'responsible_id' => 'Ответственный',
            'created_at' => 'Created time',
            'update_at' => 'Updated time',
            'id_status' => 'Статус задачи'
        ];
    }

    public function getUser() {
        return $this->hasOne(Users::class, ['id' => 'responsible_id']);
    }

    public function getStatus() {
        return $this->hasOne(Status::class, ['id' => 'id_status']);
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            $this->trigger(self::EVENT_AFTER_INSERT, new TaskEvent([
                'task' => $this
            ]));
        } else {
            $this->trigger(self::EVENT_AFTER_UPDATE, new AfterSaveEvent([
                'changedAttributes' => $changedAttributes,
            ]));
        }
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_at'],
                    ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
}
