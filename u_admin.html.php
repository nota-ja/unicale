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
	$( "#dialog-message" ).dialog({
		autoOpen: false,
		modal: true,
		buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
			}
		}
	});
}
);

</script>
<h2 id="title">設定</h2>
<div id="header3">
	<a href="u_member.php" class="button"><span class="ui-icon ui-icon-wrench" style="float:left; margin: auto;"></span>メンバー設定</a>
<?php
	if($data["islogin"]){
		echo("<span class='normal'>ログイン中：".$data['loginname']."</span>");
		echo("&nbsp;&nbsp;");
		echo("<a href='u_auth.php?action=logout' class='button' >logout</a>");
	}
?>
	<a href="." class="button">戻る</a>&nbsp;
</div>

<form method="post" action="u_admin.php" id="member">
<?php echo $data['errmsg']; ?><br>
<?php echo $data['msg'];?>

<?php //echo $data['calendar'];?>
	<span class="forprint">
		<div class="hanrei2"> 
			<?php echo $data['memberTextList'];?>
		</div> 
	</span> 
	<table class="config">
		<tr>
			<th class="configtitle">
				カレンダーの名前
			</th>
			<td>
				<input type="text" name="uni/calname"  class="text ui-widget-content ui-corner-all" value="<?php print $data['confdata']['calname']; ?>">
			</td>
		</tr>
		
		<tr>
			<th class="configtitle">
				掲示板モード
			</th>
			<td>
				<input type="checkbox" id="uni/keiji_mode" name="uni/keiji_mode" value="true" <?php if($data['confdata']['keiji_mode']=='true'){print('checked');} ?> /><label for="uni/keiji_mode">有効</label>：現在この機能は実装されていません。
			</td>
		</tr>
		<tr>
			<th class="configtitle">
				表示開始年
			</th>
			<td>
				<select name="uni/startyear">
					<option value='---'>---</option>
				<?php
					for($i=1990;$i<2037;$i++){
						$selected = "";
						if($data['confdata']['startyear']==$i){
							$selected = " selected";
						}
						print("<option value='".$i."'".$selected.">".$i."</option>\n");
					}
				?>
				</select>
			</td>
		</tr>

		<tr>
			<th class="configtitle">
				表示終了年
			</th>
			<td>
				<select name="uni/endyear">
					<option value='---'>---</option>
				<?php
					for($i=1990;$i<2037;$i++){
						$selected = "";
						if($data['confdata']['endyear']==$i){
							$selected = " selected";
						}
						print("<option value='".$i."'".$selected.">".$i."</option>\n");
					}
				?>
				</select>
				空白の場合は，表示開始年の３年後
			</td>
		</tr>
		<tr>
			<th class="configtitle">
				カスタムリンク
			</th>
			<td>
				<input type="checkbox" id="uni/custom_link" name="uni/custom_link" value="true" <?php if($data['confdata']['custom_link']=='true'){print('checked');} ?> /><label for="uni/custom_link">有効</label>
				リンク先URL<input type="text" class="text ui-widget-content ui-corner-all" id="" name="uni/custom_link_uri" value="<?php print($data['confdata']['custom_link_uri']); ?>" />：現在この機能は実装されていません。
			</td>
		</tr>

		<tr>
			<th class="configtitle">
				表示開始曜日
			</th>
			<td>
				<div id="radio01">
				<?php 
					$weekStrArray = Array("日","月","火","水","木","金","土");
					for($i=0;$i<7;$i++){
						$checked = "";
						if($data['confdata']['monorsun']==$i){
							$checked = " checked";
						}
						echo("<input type='radio' id='monorsun'".$i." name='uni/monorsun' value='".$i."'  ".$checked."/><label for='monorsun".$i."'>".$weekStrArray[$i]."</label>\n");
					}
				?>
				</div>
			</td>
		</tr>
		<tr>
			<th class="configtitle">
				月移動ナビゲーションの表示開始月
			</th>
			<td>
				<div id="radio01">
				<?php 
					for($i=1;$i<=12;$i++){
						$checked = "";
						if($data['confdata']['monthnavistartmonth']==$i){
							$checked = " checked";
						}
						echo("<input type='radio' id='uni/monthnavistartmonth'".$i." name='uni/monthnavistartmonth' value='".$i."'  ".$checked."/><label for='uni/monthnavistartmonth".$i."'>".$i."月</label>\n");
					}
				?>
				</div>
			</td>
		</tr>
		<tr>
			<th class="configtitle">
				イベントカレンダーモード
			</th>
			<td>
				<input type="checkbox" id="uni/event_calendar_mode" name="uni/event_calendar_mode" value="true" <?php if($data['confdata']['event_calendar_mode']=='true'){print('checked');} ?> /><label for="uni/event_calendar_mode">有効</label>：現在この機能は実装されていません。
			</td>
		</tr>
		<tr>
			<th class="configtitle">
				凡例のフラット表示
			</th>
			<td>
				<input type="checkbox" id="uni/disp_genre_flat" name="uni/disp_genre_flat" value="true" <?php if($data['confdata']['disp_genre_flat']=='true'){print('checked');} ?> /><label for="uni/disp_genre_flat">有効</label>：現在この機能は実装されていません。
			</td>
		</tr>
	</table>
	<input type="submit" value="更新" class="button">
</form>
