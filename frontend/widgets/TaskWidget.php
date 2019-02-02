<?php
namespace frontend\widgets;

use Yii;
use yii\base\Widget as Widget;

class TaskWidget extends Widget {
    public $id;
    public $title;
    public $description;
    public $user;
    public $date;

    public function run() {
        return $this->render('task', [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'user' => $this->user,
            'date' => $this->date
        ]);
    }

}