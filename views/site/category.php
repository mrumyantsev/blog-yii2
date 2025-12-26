<?php

/** @var yii\web\View $this */
/** @var app\models\Article[] $articles */
/** @var yii\data\Pagination $pagination */
/** @var app\models\Article[] $popular */
/** @var app\models\Article[] $recent */
/** @var app\models\Category[] $categories */

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <?php foreach ($articles as $article): ?>
                    <article class="post post-list">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="post-thumb">
                                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>"><img src="<?= $article->getImage() ?>" alt="" class="pull-left"></a>

                                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>" class="post-thumb-overlay text-center">
                                        <div class="text-uppercase text-center"><?= Yii::t('app', 'View Post') ?></div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="post-content">
                                    <header class="entry-header text-uppercase">
                                        <h6><a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]) ?>"><?= $article->category->title ?></a></h6>

                                        <h1 class="entry-title"><a href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>"><?= $article->title ?></a></h1>
                                    </header>
                                    <div class="entry-content">
                                        <p><?= $article->description ?></p>
                                    </div>
                                    <div class="social-share">
                                        <!-- author and date start -->
                                            <?= $this->render('_author-and-date', [
                                                'article' => $article,
                                            ]) ?>
                                        <!-- author and date end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>

                <!-- pagination start -->
                <?php
                    echo LinkPager::widget([
                        'pagination' => $pagination,
                        'prevPageLabel' => '<i class="fa fa-angle-double-left"></i>',
                        'nextPageLabel' => '<i class="fa fa-angle-double-right"></i>',
                    ]);
                ?>
                <!-- pagination end -->
            </div>

            <!-- sidebar start -->
            <?= $this->render('_sidebar', [
                'popular' => $popular,
                'recent' => $recent,
                'categories' => $categories,
            ]) ?>
            <!-- sidebar end -->
        </div>
    </div>
</div>
