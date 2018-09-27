<?php

namespace application\controllers;

use application\core\Controller;
use application\core\Model;


class MainController extends Controller
{

    public function indexAction() {
        if (!isset($_SESSION['authorized'])) {
            setcookie('name[bool]', 0, time()+60*60*24*30, '/');
            setcookie('name[name]', time(), time()+60*60*24*30, '/');
            $this->view->redirect('main/register');   
        }
        if ($_SESSION['authorized'] == 1) {
            setcookie('name[bool]', $_SESSION['authorized'], time()+60*60*24*30, '/');
            setcookie('name[name]', $_SESSION['name'], time()+60*60*24*30, '/');
            header("Refresh:0");
            $_SESSION['authorized'] = 2;
        }
        $messages = $this->model->get_all_message();
        $vars = [
            'messages' => $messages
        ];
        $this->view->render('главная страница', $vars);
    }

    public function registerAction() {
        if (!empty($_POST)) {
            if (!$this->model->reg_user($_POST) ) {
                $this->view->message('Ошибка: ', $this->model->error);
            }
            $this->view->location('main/index');
        }
        $this->view->render('регистрация');
    }

    public function addAction() {
        if (!empty($_POST)) {
            if (!$this->model->validate_message($_POST)) {
                $this->view->message('Ошибка: ', $this->model->error);
            }
            $id = $this->model->add_message($_POST, 0);
            if (!$id) {
                $this->view->message('Ошибка: ','ошибка обработки запроса');
            }
            $lastMessage = $this->model->get_message($id);
            $vars = [
                'lastMessage' => $lastMessage
            ];
            echo $this->view->render_message($vars);
        }
    }

    public function deleteAction() {
        $this->model->delete_message($_POST['id']);
    }

    public function likeAction() {
        $this->model->like_message($_POST['id']);
    }

    public function logoutAction() {
        $this->model->logout();
        $this->view->redirect('main/register'); 
    }

}