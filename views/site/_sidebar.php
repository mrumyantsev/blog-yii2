<?php

/** @var yii\web\View $this */
/** @var app\models\Article[] $popular */
/** @var app\models\Article[] $recent */
/** @var app\models\Category[] $categories */

use yii\helpers\Url;

?>

<div class="col-md-4" data-sticky_column>
    <div class="primary-sidebar">
        <!-- popular articles start -->
        <aside class="widget">
            <h3 class="widget-title text-uppercase text-center"><?= Yii::t('app', 'Popular Posts') ?></h3>

            <?php foreach($popular as $article): ?>
                <div class="popular-post">
                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>" class="popular-img"><img src="<?= $article->getImage() ?>" alt="">
                        <div class="p-overlay"></div>
                    </a>

                    <div class="p-content">
                        <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>" class="text-uppercase"><?= $article->title ?></a>
                        <span class="p-date"><?= $article->getDate() ?></span>
                    </div>
                </div>
            <?php endforeach; ?>

        </aside>
        <!-- popular articles end -->

        <!-- recent articles start -->
        <aside class="widget pos-padding">
            <h3 class="widget-title text-uppercase text-center"><?= Yii::t('app', 'Recent Posts') ?></h3>

            <?php foreach($recent as $article): ?>
                <div class="thumb-latest-posts">
                    <div class="media">
                        <div class="media-left">
                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>" class="popular-img"><img src="<?= $article->getImage() ?>" alt="">
                                <div class="p-overlay"></div>
                            </a>
                        </div>

                        <div class="p-content">
                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>" class="text-uppercase"><?= $article->title ?></a>
                            <span class="p-date"><?= $article->getDate() ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </aside>
        <!-- recent articles end -->

        <!-- categories start -->
        <aside class="widget border pos-padding">
            <h3 class="widget-title text-uppercase text-center"><?= Yii::t('app', 'Categories') ?></h3>
            <ul>

                <?php foreach($categories as $category): ?>
                    <li>
                        <a href="<?= Url::toRoute(['site/category', 'id' => $category->id]) ?>"><?= $category->title ?></a>
                        <span class="post-count pull-right">(<?= $category->getArticleCount() ?>)</span>
                    </li>
                <?php endforeach; ?>

            </ul>
        </aside>
        <!-- categories end -->
    </div>
</div>
