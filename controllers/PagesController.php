<?php
require_once('controllers/BaseController.php');
require_once('/home/thuan/login_form_php/helpers/session_helper.php');
class PagesController extends BaseController
{
  function __construct()
  {
    $this->folder = 'pages';
  }

  public function home()
  {
    $this->render('home');
  }

  public function login()
  {
    if(isset($_SESSION['usersName'])){
      $this->index();
    }else {
      $this->render('login');
    }
  }

  public function signup()
  {
    $this->render('signup');
  }

  public function create()
  {
    $this->render('create');
  }

  public function index()
  {
    if(!isset($_SESSION['usersName'])){
      $this->login();
    }else {
      $this->render('index');
    }
  }

  public function delete()
  {
    $this->render('delete');
  }

  public function read()
  {
    $this->render('read');
  }

  public function error()
  {
    $this->render('error');
  }
  
  public function update()
  {
    $this->render('update');
  }
}
