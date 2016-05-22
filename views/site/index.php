<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Тестовое задание';


?>
<div class="site-index">

    <div class="body-content">
    <?foreach($model as $article): ?>
        <div class="row">
            <div class="col-lg-6">
                <h2><?=Html::encode($article->title)?></h2>

                <p><?=Html::encode($article->content)?></p>

            </div>
        </div>
    <?endforeach?>
    </div>
</div>
