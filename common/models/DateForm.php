<?php

namespace common\models;

use Yii;
use yii\base\Model;

class DateForm extends Model
{
    public $dateBegin;
    public $dateEnd;

    public function rules()
    {
        return [
            [['dateBegin', 'dateEnd'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'dateBegin' => 'Начало периода',
            'dateEnd' => 'Конец периода'
        ];
    }
}
