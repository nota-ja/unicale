<?php
    ini_set( 'display_errors', 0 );
    date_default_timezone_set('Asia/Tokyo');
    require_once( "./config.php" );
    require_once( "cheetan/cheetan.php" );

function action( &$c )
{
    $c->SetViewFile( 'u_admin.html.php' );
    $errmsg	= "";
	$conf = $c->d_conf->find("");
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

	if( count( $_POST ) ){
		//------------------------------------------
		$confkey = 'calname';
		$form_data = "";
		$write_data['confvalue'] = "";
		if(isset($c->data['uni'][$confkey])){
			$form_data = $c->data['uni'][$confkey];
			if($form_data != ''){
				$write_data['confvalue'] = $form_data;
				$c->d_conf->updateby( $write_data ,'$confkey=='.$confkey);
			}else{
				$errmsg .= "カレンダー名が空です。";
			}
		}
		//------------------------------------------
		$confkey = 'keiji_mode';
		$form_data = "";
		$write_data['confvalue'] = "";
		$form_data = $c->data['uni'][$confkey];
		$write_data['confvalue'] = $form_data;
		$c->d_conf->updateby( $write_data ,'$confkey=='.$confkey);
		//------------------------------------------
		$confkey = 'startyear';
		$form_data = "";
		$write_data['confvalue'] = "";
		$form_data = $c->data['uni'][$confkey];
		$write_data['confvalue'] = $form_data;
		$c->d_conf->updateby( $write_data ,'$confkey=='.$confkey);
		//------------------------------------------
		$confkey = 'endyear';
		$form_data = "";
		$write_data['confvalue'] = "";
		$form_data = $c->data['uni'][$confkey];
		if(($form_data == "" )||($form_data == "---")){
			$form_data = $c->data['uni']['startyear']+3;
		}
		$write_data['confvalue'] = $form_data;
		$c->d_conf->updateby( $write_data ,'$confkey=='.$confkey);
		//------------------------------------------
		$confkey = 'custom_link';
		$form_data = "";
		$write_data['confvalue'] = "";
		$form_data = $c->data['uni'][$confkey];
		$write_data['confvalue'] = $form_data;
		$c->d_conf->updateby( $write_data ,'$confkey=='.$confkey);
		//------------------------------------------
		$confkey = 'custom_link_uri';
		$form_data = "";
		$write_data['confvalue'] = "";
		if(isset($c->data['uni'][$confkey])){
			$form_data = $c->data['uni'][$confkey];
			if($form_data != ''){
				$write_data['confvalue'] = $form_data;
				$c->d_conf->updateby( $write_data ,'$confkey=='.$confkey);
			}else{
				$errmsg .= "";
			}
		}
		//------------------------------------------
		$confkey = 'monorsun';
		$form_data = "";
		$write_data['confvalue'] = "";
		$form_data = $c->data['uni'][$confkey];
		$write_data['confvalue'] = $form_data;
		$c->d_conf->updateby( $write_data ,'$confkey=='.$confkey);
		//------------------------------------------
		$confkey = 'monthnavistartmonth';
		$form_data = "";
		$write_data['confvalue'] = "";
		$form_data = $c->data['uni'][$confkey];
		$write_data['confvalue'] = $form_data;
		$c->d_conf->updateby( $write_data ,'$confkey=='.$confkey);
		//------------------------------------------
		$confkey = 'event_calendar_mode';
		$form_data = "";
		$write_data['confvalue'] = "";
		$form_data = $c->data['uni'][$confkey];
		$write_data['confvalue'] = $form_data;
		$c->d_conf->updateby( $write_data ,'$confkey=='.$confkey);
		//------------------------------------------
		$confkey = 'disp_genre_flat';
		$form_data = "";
		$write_data['confvalue'] = "";
		$form_data = $c->data['uni'][$confkey];
		$write_data['confvalue'] = $form_data;
		$c->d_conf->updateby( $write_data ,'$confkey=='.$confkey);
		//------------------------------------------
		$c->redirect( "u_admin.php" );
	}
}
?>