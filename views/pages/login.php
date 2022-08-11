<?php 
include_once '/home/thuan/login_form_php/helpers/session_helper.php'; 
?>

<link rel="stylesheet" href="../../assets/login/styles.css" type="text/css">
</head>
  <body>

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1" />

<!-- ------------------------------------Navigation----------------------------------- -->

<nav id="nav" role="navigation"> <a href="#nav" title="Show navigation">Show navigation</a> <a href="#" title="Hide navigation">Hide navigation</a>
      <ul class="clearfix">
    <li><a href="index.php">Home</a></li>
    <li> <a href="./index.php?controller=pages&action=signup">Sign up</a>
        </li>
    <li> <a href="https://sun-asterisk.vn/">About</a>
        </li>
    <li><a href="https://sun-asterisk.vn/chinh-sach-phuc-loi/">Term</a></li>
  </ul>
</nav>

<!-- ------------------------------------Scripts----------------------------------- -->

  
<script src="http://osvaldas.info/examples/main.js"></script>

<script src="http://osvaldas.info/examples/drop-down-navigation-touch-friendly-and-responsive/doubletaptogo.js"></script> 
  
<script>
	$( function()
	{
		$( '#nav li:has(ul)' ).doubleTapToGo();
	});
</script>

<!-- ------------------------------------Main----------------------------------- -->

    <div class="login-box">
    <h2>Login</h2>
    <?php flash('login')?>
    <br>

    <form method="post" action="./controllers/UsersController.php">
        <div class="user-box">

        <input type="hidden" name="type" value="login">
        <input type="text" name="name/email" required="" value="<?php if(isset($_COOKIE["name/email"])) { echo $_COOKIE["name/email"]; } ?>">
        <label>Username</label>
        </div>
        <div class="user-box">
        <input type="password" name="usersPwd" required="" value="<?php if(isset($_COOKIE["usersPwd"])) { echo $_COOKIE["usersPwd"]; } ?>">
        <label>Password</label>
        </div>
        <div class="custom-check">
        <input id="q3" name="remember" type="checkbox" value="1"/>
        <label for="q3">Remember me</label>
        </div>
        <button type="submit" name="submit">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        Submit
        </button>
    </form>
    </div>
    <!-- <form>

</form> -->