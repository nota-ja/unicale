<?php
function config_database( &$db ){
	$db->add( "", "", "", "", "", DBKIND_TEXTSQL );
}

function config_models( &$controller ){
	$controller->AddModel( dirname(__FILE__) . "/models/d_data.php" );
	$controller->AddModel( dirname(__FILE__) . "/models/d_conf.php" );
	$controller->AddModel( dirname(__FILE__) . "/models/d_member.php" );
	$controller->AddModel( dirname(__FILE__) . "/models/d_genre.php" );
	$controller->AddModel( dirname(__FILE__) . "/models/d_holiday.php" );
	$controller->AddModel( dirname(__FILE__) . "/models/d_holiday_static.php" );
	$controller->AddModel( dirname(__FILE__) . "/models/d_users.php" );
}

function config_controller( &$controller ){
	$controller->SetTemplateFile( "u_template.html.php" );
}

function config_components( &$controller ){
	$controller->AddComponent( dirname(__FILE__) ."/component/unicom.php",'unicom','unicom' );
	$controller->AddComponent( dirname(__FILE__) ."/component/Calendar.php", 'Calendar', 'calendar' );
	$controller->AddComponent( dirname(__FILE__) ."/component/auth.php", 'CAuth', 'auth' );
}

function config_controller_class(){
	require_once dirname(__FILE__) . '/MyController.php';
	return 'CMyController';
}

function InitTime( $time ){
	$year	= substr( $time, 0, 4 );
	$month	= substr( $time, 4, 2 );
	$day	= substr( $time, 6, 2 );
	$hour	= substr( $time, 8, 2 );
	$minute	= substr( $time, 10, 2 );
	$second	= substr( $time, 12, 2 );
	return "$year-$month-$day $hour:$minute:$second";
}
?>