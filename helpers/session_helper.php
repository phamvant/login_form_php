<?php
if(!isset($_SESSION)){
    session_start();
}

function flash($name = '', $message = ''){
    if(!empty($name)){
        if(!empty($message) && empty($_SESSION[$name])){
            $_SESSION[$name] = $message;
        }else if(empty($message) && !empty($_SESSION[$name])){
            echo '<h2 style="color:red;">'.$_SESSION[$name].'</h2>';
            unset($_SESSION[$name]);
        }
        // unset($_SESSION[$name]);
    }
}

// function flash_update($name = '', $message = ''){
//     if(!empty($name)){
//         if(!empty($message) && empty($_SESSION[$name])){
//             $_SESSION[$name] = $message;
//         }else if(empty($message) && !empty($_SESSION[$name])){
//             echo '<h2 style="color:red;">'.$_SESSION[$name].'</h2>';
//             unset($_SESSION[$name]);
//         }
//     }
// }


function redirect($location){
    header("location: ".$location);
    exit();
}