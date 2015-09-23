	<style>
	/*
		body { font-size: 100%; }
		label, input { display:block; }
		input.text { margin-bottom:12px; width:95%; padding: .4em; }
		fieldset { padding:0; border:0; margin-top:25px; }
		h1 { font-size: 1.2em; margin: .6em 0; }
		div#users-contain { width: 350px; margin: 20px 0; }
		div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
		div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
		.ui-dialog .ui-state-error { padding: .3em; }
		.validateTips { border: 1px solid transparent; padding: 0.3em; }
	*/
	</style>
	
<script language="JavaScript">
$(function() {

	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#dialog-form" ).dialog({
		autoOpen: false,
		modal: true,
		buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
			}
		}
	});

	$( "#create-user" )
		.button()
		.click(function() {
		});
}
);


</script>
<?php print $data["errmsg"]; ?><br>
<?php echo $data['msg'];?>
<h2 id="title">メンバー設定</h2>
<div id="header3">
	<a href="u_admin.php" class="button"><span class="ui-icon ui-icon-wrench" style="float:left; margin: auto;"></span>全体設定</a>
<?php
	if($data["islogin"]){
		echo("<span class='normal'>ログイン中：".$data['loginname']."</span>");
		echo("&nbsp;&nbsp;");
		echo("<a href='u_auth.php?action=logout' class='button' >logout</a>");
	}
?>
	<a href="." class="button">戻る</a>&nbsp;
</div>

<form method="post" action="u_member_edit.php" id="member">
	<table class="config">
		<tr>
			<td>
				<table id="member_table">
					<thead>
					<tr>
						<th>&nbsp;</th>
						<th>id</th>
						<th>表示順</th>
						<th width="100">名前１（フルネーム）（例：山田太郎）</th>
						<th width="100">名前２（２文字程度）（例：山田）</th>
						<th>名前<br>１文字</th>
						<th width="100">識別色</th>
						<th width="100">凡例への表示</th>
						<th width="100">小さく表示</th>
						<th width="100">備考</th>
					</tr>
					</thead>
					<tbody>
					<?php
						foreach($data['member'] as $memberOne){
					?>
					<tr>

						<td><div class="button"><a href="u_member_edit.php?eid=<?php echo($memberOne['id']); ?>">編集</a></div></td>
						<td><?php echo($memberOne['id']); ?></td>
						<td><?php echo($memberOne['dispid']); ?></td>
						<td><?php echo($memberOne['memname1']); ?></td>
						<td><?php echo($memberOne['memname2']); ?></td>
						<td><?php echo($memberOne['memname3']); ?></td>
						<td><span class="ui-corner-all" style="width: 1em; height: 1em; background-color:#<?php echo($memberOne['color']); ?>; padding: 0.2em 1em 0.2em 1em;"><?php echo('#'.$memberOne['color']); ?>&nbsp;</span></td>
						<td><?php 
								if($memberOne['f_disp']=='true'){
									echo('はい');
								}else{
									echo('いいえ');
								}
						?></td>
						<td><?php 
								if($memberOne['f_small']=='true'){
									echo('はい');
								}else{
									echo('いいえ');
								}
						?></td>
						<td><?php echo($memberOne['bikou']); ?></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
			</td>
		</tr>
	</table>
	<input type="submit" value="メンバーの新規追加" class="button">
<form>
