<?php 
include_once '/home/thuan/login_form_php/helpers/session_helper.php'; 
?>

<link rel="stylesheet" href="../../assets/home/styles.css" type="text/css">
</head>
  <body>
<div class="container">
  <?php 
  if(isset($_SESSION['usersId'])) {
    echo '<a href="index.php?controller=employee&action=index" class="btn">';
  }else {
    echo '<a href="index.php?controller=pages&action=login" class="btn">';
  }
  ?>
  <svg width="277" height="62">
    <defs>
        <linearGradient id="grad1">
            <stop offset="0%" stop-color="#FF8282"/>
            <stop offset="100%" stop-color="#E178ED" />
        </linearGradient>
    </defs>
     <rect x="5" y="5" rx="25" fill="none" stroke="url(#grad1)" width="266" height="50"></rect>
  </svg>

    <span id="index-text">Welcome <?php if(isset($_SESSION['usersId'])){
        echo explode(" ", $_SESSION['usersName'])[0];
    }else{
        echo 'Guest';
    } 

    ?> </span>
    <div class="container">
  <?php 
  if(isset($_SESSION['usersId'])) {
    echo '<a href="./controllers/UsersController.php?q=logout" class="btn">
    <svg width="277" height="62">
    <defs>
        <linearGradient id="grad1">
            <stop offset="0%" stop-color="#FF8282"/>
            <stop offset="100%" stop-color="#E178ED" />
        </linearGradient>
    </defs>
     <rect x="5" y="5" rx="25" fill="none" stroke="url(#grad1)" width="266" height="50"></rect>
  </svg>   
   <span id="index-text">Logout </span>';
  }
  ?>

</a>
</div>
