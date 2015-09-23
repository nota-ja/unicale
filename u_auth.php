<?php
    require_once( "./config.php" );
    require_once( "cheetan/cheetan.php" );

function action( &$c )
{
	$c->SetViewFile( 'u_auth.html.php' );
    $errmsg	= "";
	$conf = $c->d_conf->find("");
	$confdata = array();
	foreach($conf as $confone){
		$confdata[$confone['confkey']] = $confone['confvalue'];
	}
	$c->set('calname', $confdata['calname']);

	if( count( $_GET ) ){
		if(isset( $_GET['action'])){
			$action = $c->sanitize->html($_GET["action"]);
			switch($action){
				case "logout":
					$c->auth->logout();
					$msg .= "ログアウトしました。<br>";
				break;
				default:
			}
		}
	}
	$rtn="";

	if( count( $_POST ) ){
		if(isset( $c->data['uni']['username']) && isset($c->data['uni']['password'])){
			$username = $c->sanitize->html($c->data['uni']['username']);
			$password = $c->sanitize->html($c->data['uni']['password']);
			$account = array('username' => $c->data['uni']['username'],
							 'password' => $c->data['uni']['password']
							);
			$rtn = $c->auth->login($account,$c);
			if($rtn){
				$msg.="ログイン成功しました。";
			}else{
				$msg.="ログインに失敗しました。";
			}
		}

		if(isset( $c->data['uni']['addusername']) && isset($c->data['uni']['addpassword']) && isset($c->data['uni']['addpasswordalt'])){
			$c->set( "isAddMemberMsg", true );
			$addUser_username = $c->sanitize->html($c->data['uni']['addusername']);
			$addUser_addpassword = $c->sanitize->html($c->data['uni']['addpassword']);
			$addUser_addpasswordalt = $c->sanitize->html($c->data['uni']['addpasswordalt']);
			if($addUser_username != ""){
				if($addUser_addpassword != $addUser_addpasswordalt){
					$addMsg .= "2つのパスワードが一致しません。";
				}else{
					$users = $c->d_users->findone('','id DESC');
					$maxID =$users['id'] + 1;
					$addMsg .= "<div id='dialog' title='管理者追加'>";
					$addMsg .= "下記の行を「d_users.txt」ファイルに追加してください。<br>";
					$addMsg .= $maxID ."##SEP##".$addUser_username."##SEP##".md5($addUser_addpassword);
					$addMsg .= "</div>";
				}
			}else{
				$addMsg .= "ユーザー名が空です。";
			}
			$c->set( "addMsg", $addMsg );
			$c->set( "tabselected", "{ selected: 1 }" );
		}
	}
	if($c->auth->islogin($c)){
		$c->redirect( "./u_admin.php" );
	}else{
		$msg .= "ログインしていません。<br>";
	}
	$c->set( "errmsg", $errmsg );
	$c->set( "msg", $msg );
}
?>