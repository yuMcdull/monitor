<?php



$AdminLog = LoadModule('Model.Admins.AdminLog');
$this->Tpl->set("ListAdminLog"    , $AdminLog->ListAdminLog());
$this->ActionResult('admin.logs.htm');
