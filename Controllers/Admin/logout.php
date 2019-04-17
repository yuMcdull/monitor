<?php


unset($_SESSION);
session_destroy();
setcookie("PubAdminKey"   ,  ''   , 0, "/", str_replace('www', '', strtolower(RootDomain)));


$this->SysTip('', ADMINS_URL);

