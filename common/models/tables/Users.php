<?php

namespace common\models\tables;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord as ActiveRecord;
use yii\db\AfterSaveEvent;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $name
 * 
 * @property Roles $role;
 */
class Users extends ActiveRecord
{
    const SCENARIO_AUTH = 'auth';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password', 'name', 'email'], 'required'],
            [['login'], 'string', 'max' => 25],
            [['password', 'name'], 'string', 'max' => 50],
            [['role_id'], 'number'],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 64],
            [['updated_at', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'role_id' => 'Role',
            'email' => 'E-mail',
            'created_at' => 'Created time',
            'update_at' => 'Updated time'
        ];
    }

    public function fields() {
        if ($this->scenario == self::SCENARIO_AUTH) {
            return [
                'id',
                'username' => 'login',
                'password',
                'language_id'
            ];
        }

        return parent::fields();
    }

    public function getRole() {
        return $this->hasOne(Roles::class, ["id" => "role_id"]);
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
