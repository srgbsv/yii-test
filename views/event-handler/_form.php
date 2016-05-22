<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EventHandler */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="event-handler-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::label('Событие:') ?><br>
    <?= $form->field($model, 'event_model')->dropDownList($events, ['prompt' => 'Выберите модель']) ?>
    <div class="model-params">
        <?= $form->field($model, 'event_name')->dropDownList([]); ?>
        <?= Html::dropDownList('recipient_type', 0, ['Все', 'Пользователь', 'Поле модели'])?>
        <?= $form->field($model, 'recipient')->dropDownList([]) ?>
        <?= $form->field($model, 'transport')->dropDownList($transport) ?>

        <?= $form->field($model, 'template')->textarea() ?>

        <div class="params-wrap"></div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
