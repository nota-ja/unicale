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
	.button{font-size:80%;}
	</style>

<script type="text/javascript" src="js/jquery.simple-color.min.js"></script>
<script language="JavaScript">
$(function() {
	$('.simple_color').simpleColor({
		cellWidth: 9,
		cellHeight: 9,
		displayColorCode: true,
		border: '1px solid #ffffff',
		buttonClass: 'text ui-widget-content ui-corner-all'
	});

	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$( "#create-user" )
		.button()
		.click(function() {
			$( "#dialog-form" ).dialog( "open" );
		});

	$('input#alert_button').click( function() {
		alert($('input.simple_color_custom')[0].value);
	})
	
});

</script>
<?php echo($data["errmsg"]); ?><br>
<h2 id="title">メンバー編集</h2>
<div id="header3">
<?php
	if($data["islogin"]){
		echo("<span class='normal'>ログイン中：".$data['loginname']."</span>");
		echo("&nbsp;&nbsp;");
		echo("<a href='u_auth.php?action=logout' class='button' >logout</a>");
	}
?>

</div>

<form method="post">
<table class="config">
	<tr>
		<td>
			<label for="id">id</label>
		</td>
		<td>
			<?php echo $data['id'];?>
		</td>
	</tr>
	<tr>
		<td>
			<label for="dispid">表示順</label>
		</td>
		<td>
			<input type="text" name="uni/dispid" id="dispid" class="text ui-widget-content ui-corner-all" value="<?php echo $data['dispid'];?>" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="secondname">名前１（フルネーム）</label>
		</td>
		<td>
			<input type="text" name="uni/memname1" id="memname1" class="text ui-widget-content ui-corner-all" value="<?php echo $data['memname1'];?>" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="memname2">名前２（２文字程度）</label>
		</td>
		<td>
			<input type="text" name="uni/memname2" id="memname2" class="text ui-widget-content ui-corner-all" value="<?php echo $data['memname2'];?>" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="memname3">名前（１文字）</label>
		</td>
		<td>
			<input type="text" name="uni/memname3" id="memname3" class="text ui-widget-content ui-corner-all" size="2" value="<?php echo $data['memname3'];?>" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="color">識別色</label>
		</td>
		<td>
			<input type="text" name="uni/color" id="color" class="button simple_color" value="<?php echo $data['color'];?>" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="f_disp">凡例への表示</label>
		</td>
		<td>
			<input type="checkbox" name="uni/f_disp" id="f_disp" class="text ui-widget-content ui-corner-all" value="true" <?php if($data['f_disp']=='true'){echo('CHECKED');}?> />
		</td>
	</tr>
	<tr>
		<td>
			<label for="f_small">小さく表示</label>
		</td>
		<td>
			<input type="checkbox" name="uni/f_small" id="f_small" class="text ui-widget-content ui-corner-all" value="true" <?php if($data['f_small']=='true'){echo('CHECKED');}?> />
		</td>
	</tr>
	<tr>
		<td>
			<label for="bikou">備考</label>
		</td>
		<td>
			<input type="text" name="uni/bikou" id="bikou" class="text ui-widget-content ui-corner-all" value="<?php echo $data['bikou'];?>" />
		</td>
	</tr>
	</table>
	<input type="hidden" name="uni/editid" value="<?php echo $data['editid'];?>">
	<input type="submit" value="更新" class="button"><input type="button" class="button" value="キャンセル" onClick="location.href='u_member.php';">
</form>

<a href=".">back</a>

