<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chunk */

$this->title = 'Update Chunk: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Chunks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chunk-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
