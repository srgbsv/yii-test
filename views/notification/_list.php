<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use app\models\Notification;
?>

<div class="alert <?= ($model->status==Notification::STATUS_UNREAD)?'alert-info':'alert-success'?>">
	<span class="date"><?= date("Y:m:y h:m:s", $model->date); ?></span><div class="notify"><?= Html::encode($model->content)?> <?= ($model->status == Notification::STATUS_UNREAD)?Html::a('Прочитано', ['notification/read/'.$model->id], ['class'=>'btn btn-success notify-read'] ):''?></div>
</div>