<?php
class CAuth extends CModel
{
//	var $name = '';
	var $table = 'd_users';

	var $validatefunc = array(
			'username'	=> 'notempty',
			'password'	=> array( 'notempty', 'eisu' ),
		);

	var $validatemsg = array(
			'username'	=> 'ユーザー名を入力してください。<br />',
			'password'	=> array(
					'パスワードを入力してください。<br />',
					'パスワードの有効な文字は英数字です。<br />'
				),
		);

	// --------------------------------------------------------------------

	function __construct()
	{
		CModel::CModel();
	}

	// --------------------------------------------------------------------

	function CAuth()
	{
		$this->__construct();
	}

	// --------------------------------------------------------------------

	// アカウントの作成
	// @param	array	$account	アカウント情報
	// @param	bool	$auto_login	ログインフラグ
	// @return	bool
	function create( $account = array(), $auto_login = TRUE )
	{
		if ( $account['username'] == '' || $account['password'] == '' ) {
			return FALSE;
		}

		$user = $this->escape( $account['username'] );
		if ( $this->getcount( "username='{$user}'" ) ) {
			return FALSE;
		}

		$account['password'] = md5( $account['password'] );

		if ( ! $this->insert( $account ) ) {
			return FALSE;
		}

		$user_id = $this->GetLastInsertId();

		if ( $auto_login ) {
			// セッションにログインを保存
			$_SESSION['user_id']	= $user_id;
			$_SESSION['username']	= $account['username'];
			$_SESSION['password']	= $account['password'];
			$_SESSION['logined']	= TRUE;
		}
		return TRUE;

	}

	// --------------------------------------------------------------------

	// アカウントの削除
	// @param	integer	$user_id	ユーザーID
	// @return	bool
	function delete( $user_id )
	{
		if( ! is_numeric( $user_id ) ) {
			return FALSE;
		}

		$user_id = $this->escape( $user_id );
		return $this->del( "id='{$user_id}'" );
	}

	// --------------------------------------------------------------------

	// ログイン処理
	// @param	array	$account	アカウント情報
	// @return	bool
	function login( $account = array(),&$c )
	{
		if ( $account['username'] == '' || $account['password'] == '' ) {
			return FALSE;
		}
/*
echo("username=".$account['username']."<br>");
echo("password=".md5($account['password'])."<br>");
echo("SESSION_username=".$_SESSION['username']."<br>");
echo("SESSION_password=".$_SESSION['password']."<br>");
*/

		if ( $_SESSION['username'] == $account['username'] ) {
				return FALSE;
		}

//		$user = $this->escape( $account['username'] );
//		$pass = $this->escape( md5( $account['password'] ) );
		$user = $account['username'];
		$pass = md5( $account['password']);


		if($row = $c->d_users->findone( '$username=='.$user)){
			if($row['password'] == md5($account['password'])){
				$_SESSION['user_id']	= $row['id'];
				$_SESSION['username']	= $row['username'];
				$_SESSION['password']	= $row['password'];
				$_SESSION['logined']	= TRUE;
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

		// セッションにログインを保存
	}

	// --------------------------------------------------------------------

	// ログイン中か
	// @param	array	$account	アカウント情報
	// @return	bool
	function islogin(&$c)
	{
		$user_id  = $c->sanitize->html($_SESSION['user_id']);
		$username = $c->sanitize->html($_SESSION['username']);
		$password = $c->sanitize->html($_SESSION['password']);
		$logined  = $c->sanitize->html($_SESSION['logined']);
		if(($username!="")&&($user_id!="")&&($password!="")&&($logined!="")){
			if($row = $c->d_users->findone('$username=='.$username)){
				if($row['password'] == $password){
					if($logined == TRUE){
						return TRUE;
					}
				}
				return FALSE;
			}
			return FALSE;
		}
		return FALSE;
	}

	// --------------------------------------------------------------------

	// ログアウト処理
	// @return	void
	function logout()
	{
		if ( isset( $_SESSION['logined'] ) ) {
			// セッション変数を消去
			unset( $_SESSION['user_id'] );
			unset( $_SESSION['username'] );
			unset( $_SESSION['password'] );
			unset( $_SESSION['logined'] );

			// セッションクッキーを削除
			if ( isset( $_COOKIE[session_name()] ) ) {
				setcookie( session_name(), '', time() - 42000, '/' );
			}

			// セッションを破壊
			session_destroy();
		}
	}

	// --------------------------------------------------------------------

	// パスワード変更
	// @param	array	$account	アカウント情報
	// @return	bool
	function change_password( $account = array() )
	{
		if ( $account['username'] == '' || $account['password'] == '' ) {
			return FALSE;
		}

		$user = $this->escape( $account['username'] );
		if ( ! $row = $this->findone( "username='{$user}'" ) ) {
			return FALSE;
		}

		$row['password'] = md5( $account['password'] );

		return $this->update( $row );
	}

}
