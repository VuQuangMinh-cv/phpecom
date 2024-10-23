<?php
include("../functions/myfunctions.php");

if(isset($_SESSION['auth']))
{
    if($_SESSION['role_as'] != 2) // quyen danh cho nhan vien
    {
        redirect("../index.php","You are not authorized to access this page");
    }
}
else
{
    redirect("../login.php","Login to continue");

}

?>