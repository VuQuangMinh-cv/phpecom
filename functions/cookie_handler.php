<?php
function setLoginCookies($user_data) {
    setcookie('user_id', $user_data['id'], 0, "/");  
    setcookie('user_name', $user_data['name'], 0, "/");  
    setcookie('user_email', $user_data['email'], 0, "/");  


    // setcookie('user_id', $user_data['id'], time() + (86400 * 30), path: "/");

}
?>
