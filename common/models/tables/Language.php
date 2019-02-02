<?php

namespace common\models\tables;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\tables\Users;

/**
 * This is the model class for table "language".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 *
 * @property Users[] $users
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 25],
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
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['language_id' => 'id']);
    }

    public static function getLanguageList() {
        $languages = static::find()
            ->select(['id', 'name'])
            ->asArray()
            ->all();

        return ArrayHelper::map($languages, 'id', 'name');
    }

    public function setLanguageApp($idLang = null) {
        if ($idLang) {
            if ($user_id = Yii::$app->user->identity->id) {
                $user = Users::findOne([$user_id]);
                $user->language_id = $idLang;
                $user->save();
                Yii::$app->user->identity->language_id = $idLang;
            } else {
                Yii::$app->session->set('langId', $idLang);
            }
        } else {
            if (!$idLang = Yii::$app->user->identity->language_id) {
                $session = Yii::$app->session;
                $idLang = $session->has('langId') ? +$session->get('langId') : 1;
                $session->set('langId', $idLang);
            }
        }

        $language = $this->findOne($idLang);
        Yii::$app->language = $language['value'];
    }
}
