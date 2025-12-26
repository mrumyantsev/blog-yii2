<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignupForm;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $loginForm = new LoginForm();

        if (
            $this->request->isPost &&
            $loginForm->load($this->request->post()) &&
            $loginForm->login()
        ) {
            return $this->goBack();
        }

        $loginForm->password = '';
        
        return $this->render('login', [
            'loginForm' => $loginForm,
        ]);
    }
    
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        
        return $this->goHome();
    }

    /**
     * Signup action.
     *
     * @return Response
     */
    public function actionSignup()
    {
        $signupForm = new SignupForm();

        if (
            $this->request->isPost &&
            $signupForm->load($this->request->post()) &&
            $signupForm->signup()
        ) {
            return $this->redirect('login');
        }

        return $this->render('signup', [
            'signupForm' => $signupForm,
        ]);
    }

}
