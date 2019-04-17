<?php


$AdminLogin = LoadModule('Model.Admins.AdminLogin');

$this->Tpl->set("ListAdminLogin"    , $AdminLogin->ListAdminLogin());
$this->ActionResult('admin.login.htm');