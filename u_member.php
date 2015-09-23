<?php
    require_once( "./config.php" );
    require_once( "cheetan/cheetan.php" );

function action( &$c )
{
	$c->SetViewFile( 'u_member.html.php' );
	$errmsg = "";
	$conf = $c->d_conf->find("");
	$member = $c->d_member->find("","dispid ASC");
	$confdata = array();
	foreach($conf as $confone){
		$confdata[$confone['confkey']] = $c->sanitize->html($confone['confvalue']);
	}
	$c->set('confdata',$confdata);
	$c->set('calname', $confdata['calname']);


	$isLogin = false;
	if($c->auth->islogin($c)){
		$loginName = $c->sanitize->html($_SESSION['username']);
		$isLogin = true;
	}else{
		$msg .= "ログインしていません。<br>";
		$c->redirect( "./u_auth.php" );
	}
	$c->set( 'islogin', $isLogin );
	$c->set( 'loginname', $loginName);

	$c->set( 'msg', $msg );
	$c->set( 'errmsg', $errmsg );
	$c->set( 'member', $member );
}
?>