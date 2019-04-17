<?php


//Server::InitSysConfig();
global $ConfigDB;
define("DBName", $ConfigDB['Mysql']['Master']['dbname']);

defined('SPLIT') or define('SPLIT', 0);
AdminSDKType(SPLIT);

/** 根据 SYSCURTYPE 判断是添加 SDKType 字段插入语句**/
define('IntSDKKey',defined('SYSCURTYPE') && ''!=SYSCURTYPE ? ',`SDKType`':'');
define('IntSDKVal',defined('SYSCURTYPE') && ''!=SYSCURTYPE ? ",'".SYSCURTYPE."'":'');

$this->Tpl->set('CH_Root'   ,   CH_Root);
$this->Tpl->set('DEBUG'     ,   CHDEBUG);

# 主站初始化文件
$this->Tpl->set('SiteName'  ,   SiteName);
$this->Tpl->set('RootDomain',   RootDomain);
$this->Tpl->set('MAINHOST'  ,   MAINHOST);
$this->Tpl->set('ADMINS_URL',   ADMINS_URL);
$this->Tpl->set('INDEXS_URL',   INDEXS_URL);
$this->Tpl->set('Version',   Version);


$this->Tpl->set('HOSTSERVER',   HOSTSERVER);
$this->Tpl->set('PAYSERVER' ,   PAYSERVER);

$this->Tpl->set("_GET"      ,   $_GET);
$this->Tpl->set("_COOKIE"   ,   $_COOKIE);

$this->Tpl->set("NOWTIME"   ,   SysTime());
$this->Tpl->set("CountryVersion"      ,   CountryVersion);

$SDKType = (SYSCURTYPE != '') ? SYSCURTYPE : '';
$this->Tpl->set("SDKType"   , $SDKType);

//$Skin = defined('SysDefSkin') ? SysDefSkin : 'default';
$this->Tpl->set('TplURL'  ,  '/Tpl/Admin/');
if(!isset($_COOKIE['AdminLang']) || empty($_COOKIE['AdminLang']))
{
    setcookie("AdminLang"  ,  'Chinese'   , time()+864000, "/", str_replace('www', '', strtolower(RootDomain)));
    $this->SysTip('', MAINHOST.ADMINS_URL);
}
elseif($_SESSION['CH_AdminID']>0)
{
    $ViewAdminTheme = LoadModule('Model.Admins.AdminUsers')->ViewAdminThemes($_SESSION['CH_AdminID']);
    $ViewAdminTheme = $ViewAdminTheme?:array('Themes'=>0,'InputColor'=>0,'ButtonColor'=>0,'Collect'=>'');
    $filename=WEBPATH.'/SysInit.lock';
    $this->Tpl->set('LoginInfo'     ,  $_SESSION);
    $this->Tpl->set('ViewAdminTheme',  $ViewAdminTheme);
}
elseif(count($_POST)>0 && $_SESSION['CH_AdminID']<1)
{
	$AdminLogin = & LoadModule('Model.Admins.AdminLogin');
    $AdminLogin->LoginAdmin();
	$this->SysTip('', MAINHOST.ADMINS_URL);
}
else
{
	$this->ActionResult('login.htm');
    exit;
}

if (CHDEBUG != 'y')
{
    if(session_status() == PHP_SESSION_ACTIVE && $_SESSION['CH_AdminWritable'] != 1)
    {
        //权限判断
        $RequestCH = strtolower($_GET['CH']);
        $AminUrl = "http://admin.joyeggs.com/?CH=Admin.Right&Opt=UserRightMap&Key=".$RequestCH;
        if (RightMap($AminUrl))
                $this->SysTip(_Font('权限不足！禁止此操作！'));
        }elseif (session_status() != PHP_SESSION_ACTIVE){
            $this->ActionResult('login.htm');
            exit;
    } 
}

// 请求统计
//if (CHDEBUG == 'y')
//{
//    $IsOpenRequestStatistics = 1;
//    if ($IsOpenRequestStatistics)
//        LoadModule('Model.Statistic.RequestStatistics')->CollectAdmin();
//}

