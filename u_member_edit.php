<?php
    require_once( "./config.php" );
    require_once( "cheetan/cheetan.php" );

function action( &$c )
{
    $c->SetViewFile( 'u_member_edit.html.php' );
    $errmsg	= "";

	$conf = $c->d_conf->find("");
	$confdata = array();
	foreach($conf as $confone){
		$confdata[$confone['confkey']] = $confone['confvalue'];
	}
	$c->set('confdata',$confdata);
	$c->set('calname', $confdata['calname']);

	$isLogin = false;
	if($c->auth->islogin(&$c)){
		$loginName = $c->sanitize->html($_SESSION['username']);
		$isLogin = true;
	}else{
		$msg .= "ログインしていません。<br>";
		$c->redirect( "./u_auth.php" );
	}
	$c->set( 'islogin', $isLogin );
	$c->set( 'loginname', $loginName);

	if( count( $_POST ) ){
		$errmsg .= "f_small=".$c->data['uni']['f_small'];
		if(isset($c->data['uni']['editid'])){
			if($c->data['uni']['editid'] != ""){
				$editID = $c->data['uni']['editid'];
				if(!isset($c->data['uni']['f_disp'])){
					$c->data['uni']['f_disp'] = 'false';
				}
				if(!isset($c->data['uni']['f_small'])){
					$c->data['uni']['f_small'] = 'false';
				}
				$c->data['uni']['color'] = str_replace("#","",$c->data['uni']['color']);
				$update_data = $c->data['uni'];
				$update_data['id'] = $editID;
				$c->d_member->update($update_data);

				$c->set( 'msg', $msg );
				$c->set( 'errmsg', $errmsg );
				$c->redirect( "./u_member.php" );
			}else{

				if(!isset($c->data['uni']['f_disp'])){
					$c->data['uni']['f_disp'] = 'false';
				}
				if(!isset($c->data['uni']['f_small'])){
					$c->data['uni']['f_small'] = 'false';
				}
				$c->data['uni']['color'] = str_replace("#","",$c->data['uni']['color']);
				$insertData = $c->data["uni"];
				$c->d_member->insert( $insertData );

				$c->set( 'msg', $msg );
				$c->set( 'errmsg', $errmsg );
				$c->redirect( "./u_member.php" );
			}
		}else{
			//NOP
		}
	}
	if( count( $_GET ) ){
		$d = $c->s->get('d');
	
		$err .= $c->v->number( $d, 'wrong Number.' );
		$err .= $c->v->len( $d, 8,'wrong Length.' );

		$editID = $c->s->get('eid');
		$errmsg .= $c->v->number( $editID, 'wrong Number.' );
		$errmsg .= $c->v->len( $editID, 8,'wrong Length.' );

		if($errmsg == ""){
			$editMember = $c->d_member->findone( '$id==' . $editID );
			$c->set( 'id', $editMember['id']);
			$c->set( 'dispid', $editMember['dispid']);
			$c->set( 'memname1', $editMember['memname1']);
			$c->set( 'memname2', $editMember['memname2']);
			$c->set( 'memname3', $editMember['memname3']);
			$c->set( 'color', $editMember['color']);
			$c->set( 'f_disp', $editMember['f_disp']);
			$c->set( 'f_small', $editMember['f_small']);
			$c->set( 'bikou', $editMember['bikou']);
			$c->set( 'editid', $editID);
		}
	}
	$c->set( 'msg', $msg );
	$c->set( 'errmsg', $errmsg );

}
?>