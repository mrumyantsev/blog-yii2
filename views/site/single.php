<?php

/** @var yii\web\View $this */
/** @var app\models\Article $article */
/** @var app\models\Article[] $popular */
/** @var app\models\Article[] $recent */
/** @var app\models\Category[] $categories */
/** @var app\models\Comment[] $comments */
/** @var app\models\CommentForm $commentForm */

use yii\helpers\Url;

?>

<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                        <a href="<?= $article->getImage() ?>"><img src="<?= $article->getImage() ?>" alt=""></a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]) ?>"><?= $article->category->title ?></a></h6>

                            <h1 class="entry-title"><a href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>"><?= $article->title ?></a></h1>
                        </header>
                        <div class="entry-content">
                            <?= $article->content ?>
                        </div>
                        <div class="decoration">

                            <?php foreach ($article->tags as $tag): ?>
                                <a href="#" class="btn btn-default"><?= $tag->title ?></a>
                            <?php endforeach; ?>

                        </div>

                        <div class="social-share">
							<!-- author and date start -->
                                <?= $this->render('_author-and-date', [
                                    'article' => $article,
                                ]) ?>
                            <!-- author and date end -->

                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="s-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="s-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a class="s-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="s-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </article>

                <!-- comments start -->
                <?= $this->render('_comments', [
                    'article' => $article,
                    'comments' => $comments,
                    'commentForm' => $commentForm,
                ]) ?>
                <!-- comments end -->
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
