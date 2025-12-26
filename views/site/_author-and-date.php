<?php

/** @var yii\web\View $this */
/** @var app\models\Article $article */

?>

<span class="social-share-title pull-left">
    <?= sprintf(
        Yii::t('app', 'By %s On %s'),
        $article->author->name,
        $article->getDate()) ?>
</span>
