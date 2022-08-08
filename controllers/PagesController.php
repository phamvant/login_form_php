<?php
require_once('controllers/BaseController.php');

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
    $this->render('login');
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
    $this->render('index');
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
