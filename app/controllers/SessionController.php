<?php

namespace Vokuro\Controllers;

use Vokuro\Forms\LoginForm,
    Vokuro\Forms\SignUpForm,
    Vokuro\Forms\ForgotPasswordForm,
    Vokuro\Auth\Auth,
    Vokuro\Auth\Exception as AuthException,
    Vokuro\Models\Users,
    Vokuro\Models\ResetPasswords;

class SessionController extends ControllerBase
{

    public function initialize()
    {
        
        $this->view->setTemplateBefore('public');
        
    }

    public function indexAction()
    {
        return $this->response->redirect('/login');
    }

    /**
     * Starts a session in the admin backend
     */
    public function loginAction()
    {

        // if ($this->cookies->has('logged-in') and $this->cookies->get('logged-in') == 'logged-in' and $this->getUserId()) {
        //     $this->response->redirect('contenttype/list');
        // }
        
        $form = new LoginForm();
       
        try {

            if (!$this->request->isPost()) {

                if ($this->auth->hasRememberMe()) {
                    //unset($_COOKIE['logged-in']);
                    setcookie("logged-in", 'logged-in', time() * 3600, '/');
                    return $this->auth->loginWithRememberMe();
                }

               
            } else {

                if ($form->isValid($this->request->getPost()) == false) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                } else {

                    $this->auth->check(array(
                        'email' => $this->request->getPost('email'),
                        'password' => $this->request->getPost('password'),
                        'remember' => $this->request->getPost('remember')
                    ));

                    $message = 'Logged in successfully';
                    $this->log($message);

                    //$this->cookies->set('logged-in', 'logged-in', time() + 15 * 86400);
                    //unset($_COOKIE['logged-in']);
                    setcookie("logged-in", 'logged-in', time() + 1 * 3600, '/');
                    return $this->redirectTo();
                }
            }

        } catch (AuthException $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->form = $form;
    }

    private function redirectTo()
    {

        $profile = $this->getUserProfile();
        if ($profile == 'Administrators') {
            return $this->response->redirect('contenttype');
        } else if ($profile == 'Master Trainers') {
            return $this->response->redirect('contenttype/list');
        } else if ($profile == 'Site Admin') {
            return $this->response->redirect('contenttype/list');
        } else if ($profile == 'Content Manager') {
            return $this->response->redirect('contenttype/list');
        }
       
    }

    /**
     * Shows the forgot password form
     */
    public function forgotPasswordAction()
    {

        $form = new ForgotPasswordForm();

        if ($this->request->isPost()) {


            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $user = Users::findFirstByEmail($this->request->getPost('email'));

                if (!$user) {
                    $this->flash->success('There is no account associated to this email');
                } else {

                    $resetPassword = new ResetPasswords();
                    $resetPassword->usersId = $user->id;

                    if ($resetPassword->save()) {
                        $this->flash->success('Success! Please check your messages for an email reset password');
                    } else {
                        foreach ($resetPassword->getMessages() as $message) {
                            $this->flash->error($message);
                        }
                    }
                }
            }
        }

        $this->view->form = $form;

    }

    /**
     * Closes the session
     */
    public function logoutAction()
    {
        $message = 'Logout successfully';
        $this->log($message);

        unset($_COOKIE['logged-in']);
        setcookie("logged-in", 'logged-out', time() - 3600, '/');
        $this->session->destroy();
        $this->auth->remove();

        return $this->response->redirect('user');
    }

}