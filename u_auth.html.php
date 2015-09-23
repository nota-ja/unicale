<script language="JavaScript">
$(function() {
	$( "#tabs" ).tabs(<?php print $data["tabselected"]; ?>);
});

</script>

<div id="tabs" style="font-size:90%; width: 800px; margin: 0 auto 1em auto;">
	<ul>
		<li><a href="#tabs-1">ログイン</a></li>
		<li><a href="#tabs-2">管理者追加</a></li>
	</ul>
	<div id="tabs-1">
		<form method="post" action="u_auth.php" id="member" name="login">
			<?php print $data["errmsg"]; ?><br>
			<?php echo $data['msg'];?>
			<table class="config">
				<tr>
					<th class="configtitle">
						ユーザー名
					</th>
					<td>
						<input type="text" name="uni/username" value="">
					</td>
				</tr>
				<tr>
					<th class="configtitle">
						パスワード
					</th>
					<td>
						<input type="password" name="uni/password" value="">
					</td>
				</tr>
			</table>
			<input type="submit" value="ログイン">
		</form>
	</div>
	<div id="tabs-2">
		<form method="post" action="u_auth.php" id="addmember" name="addmember">
			<div><?php 
			if($data['isAddMemberMsg']==true){
		//		echo("<div id='dialog-message' title='Information to Add a Member' style='font-size: 80%;'>");
				echo ($data['addMsg']);
		//		echo ("</div>\n");
			}
			?></div>
			<table class="config">
				<tr>
					<th class="configtitle">
						ユーザー名
					</th>
					<td>
						<input type="text" name="uni/addusername" value="">
					</td>
				</tr>
				<tr>
					<th class="configtitle">
						パスワード
					</th>
					<td>
						<input type="password" name="uni/addpassword" value="">
					</td>
				</tr>
				<tr>
					<th class="configtitle">
						パスワード（確認用再入力）
					</th>
					<td>
						<input type="password" name="uni/addpasswordalt" value="">
					</td>
				</tr>
			</table>
			<input type="submit" value="ユーザー追加">
		</form>
	</div>
</div>
