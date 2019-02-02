<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller as Controller;
use yii\data\ActiveDataProvider;
//use app\models\Task as Task;
use common\models\tables\Tasks;
use common\models\tables\Users;
use common\models\tables\Status;
use yii\helpers\ArrayHelper;
use common\models\DateForm;
use common\models\tables\Comments;
use yii\web\UploadedFile;
use common\models\tables\TaskComment;
use frontend\services\TaskLabel;

class TaskController extends Controller {

    public function actionIndex() {
        $session = Yii::$app->session;
        if (Yii::$app->request->method == 'POST') {
            $dateModel = new DateForm();
            $dateModel->load(Yii::$app->request->post());
            $session->set('dateModel', $dateModel);
        } else {
            $dateModel = $session->has('dateModel') ? $session->get('dateModel') : new DateForm();
        }
        
        $query = Tasks::find()
            ->andFilterWhere(['>=', 'date', $dateModel->dateBegin])
            ->andFilterWhere(['<=', 'date', $dateModel->dateEnd]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'dateModel' => $dateModel,
        ]);
    }

    private function createLabelPageOneItem() {
        $labelPage = new TaskLabel();
        $labelPage->descriptionLabel = Yii::t('taskItem', 'descriptionLabel');
        $labelPage->nameLabel = Yii::t('taskItem', 'nameLabel');
        $labelPage->dateLabel = Yii::t('taskItem', 'dateLabel');
        $labelPage->responsibleLabel = Yii::t('taskItem', 'responsibleLabel');
        $labelPage->statusLabel = Yii::t('taskItem', 'statusLabel');
        $labelPage->buttonChange = Yii::t('taskItem', 'buttonChange');
        $labelPage->commentLoginLabel = Yii::t('taskItem', 'commentLoginLabel');
        $labelPage->commentsTaskLabel = Yii::t('taskItem', 'commentsTaskLabel');
        $labelPage->userLabel = Yii::t('taskItem', 'userLabel');
        $labelPage->nameCommentLabel = Yii::t('taskItem', 'nameCommentLabel');
        $labelPage->commentLabel = Yii::t('taskItem', 'commentLabel');
        $labelPage->addCommentLabel = Yii::t('taskItem', 'addCommentLabel');

        return $labelPage;
    }

    public function actionItem($id) {
        $model = Tasks::findOne($id);
        $user_id = Yii::$app->user->identity->id;
        $modelComment = new Comments();

        if ($modelComment->load(Yii::$app->request->post())){
            $modelComment->user_id = $user_id;
            $modelComment->task_id = $id;
            
            if ($modelComment->img_path = UploadedFile::getInstance($modelComment, 'img_path')) {
                $modelComment->upload();
            }
            $modelComment->save();
        }

        $query = Comments::find()
            ->where(['task_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6
            ]
        ]);

        $labelPage = $this->createLabelPageOneItem();

        return $this->render('item', [
            'model' => $model,
            'user_id' => $user_id,
            'modelComment' => new Comments(),
            'dataProvider' => $dataProvider,
            'labelPage' => $labelPage
        ]);
    }

    public function actionCreate() {
        $model = new Tasks();

        $users = Users::find()->all();
        $usersList = ArrayHelper::map($users, 'id', 'name');

        $status = Status::find()->all();
        $statusList = ArrayHelper::map($status, 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'usersList' => $usersList,
            'statusList' => $statusList
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $users = Users::find()->all();
        $usersList = ArrayHelper::map($users, 'id', 'name');

        $status = Status::find()->all();
        $statusList = ArrayHelper::map($status, 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'usersList' => $usersList,
            'statusList' => $statusList
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}