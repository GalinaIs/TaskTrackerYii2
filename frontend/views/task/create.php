<h2>Введите данные для создания новой задачи:</h2>

<?= $this->render('_form', [
        'model' => $model,
        'usersList' => $usersList,
        'statusList' => $statusList
]) ?>