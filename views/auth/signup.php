<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\SignupForm $signupForm */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = Yii::t('app', 'Sign Up');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="leave-comment mr0">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="site-login">
                <h1><?= Html::encode($this->title) ?></h1>
            
                <p><?= Yii::t('app', 'Please fill out the following fields to login:') ?></p>
            
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-1 control-label'],
                    ],
                ]); ?>
            
                    <?= $form->field($signupForm, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($signupForm, 'email')->textInput() ?>
            
                    <?= $form->field($signupForm, 'password')->passwordInput() ?>
            
                    <div class="form-group">
                        <div style="margin-top: 15px;">
                            <?= Html::submitButton(Yii::t('app', 'Register'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>
                    </div>
            
                <?php ActiveForm::end(); ?>
            
                <div class="col-lg-offset-1" style="color:#999;">
                </div>
            </div>
        </div>
    </div>
</div>
