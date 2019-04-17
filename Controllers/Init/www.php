<?php


Server::InitSysConfig();
global $ConfigDB;
define("DBName", $ConfigDB['Mysql']['Master']['dbname']);
define("HostID", $this->DBHost[DBName]);

defined('SPLIT') or define('SPLIT', 0);
IndexSDKType(SPLIT);


/** 根据 SYSCURTYPE 判断是添加 SDKType 字段插入语句**/
define('IntSDKKey', (defined('SYSCURTYPE') && SYSCURTYPE != '') ? ',`SDKType`' :  '');
define('IntSDKVal', (defined('SYSCURTYPE') && SYSCURTYPE != '') ? ",'".SYSCURTYPE."'"  :  '');

$this->Tpl->set('CH_Root'   ,   CH_Root);
$this->Tpl->set('DEBUG'     ,   CHDEBUG);

# 主站初始化文件
$this->Tpl->set('SiteName'  ,   SiteName);
$this->Tpl->set('RootDomain',   RootDomain);
$this->Tpl->set('MAINHOST'  ,   MAINHOST);
$this->Tpl->set('INDEXS_URL',   INDEXS_URL);
$this->Tpl->set("NOWTIME"   ,   SysTime());
$this->Tpl->set("_GET"      ,   $_GET);


$this->Tpl->set("CountryVersion"      ,   CountryVersion);

$UserID = (int)trim(($_SESSION['CH_UserID']>0) ? $_SESSION['CH_UserID'] : $_GET['UserID']);


$KuaHostDB = array();
$KuaSuper = in_array($DBName,$KuaHostDB) ? 1 : 0;

// 请求统计
if (CHDEBUG == 'y')
{
    $IsOpenRequestStatistics = 1;
    if ($IsOpenRequestStatistics)
        LoadModule('Model.Statistic.RequestStatistics')->CollectClient();
}
