<script language="JavaScript">
$(function() {
	$( "#tabs" ).tabs();
});
</script>

<form method="post" action="u_edit.php?id=<?php print $data["data"]["id"]; ?>">
<font color="red"><?php print $data["errmsg"]; ?></font>
<?php echo $data['msg'];?>
	<span class="forprint"> 
		<div class="hanrei2"> 
			<?php echo $data['memberTextList'];?>
		</div> 
	</span> 

	<div id="header1"> 
		<div id="tabs" style="font-size: 80%; width: 800px; margin: 0 auto 0 auto;">
			<ul>
				<li><a href="#tabs-1">スケジュール情報</a></li>
			</ul>

			<div id="tabs-1" style="text-align: center;">
				<table border="0" cellspacing="10">
					<tr>
						<td class="normal">
							<?php echo $data['yearListbox'];?>年
							<?php echo $data['monthListbox'];?>月
							<?php echo $data['dayListbox'];?>日
						</td>
						<td class="normal">
							用事<input type="text" name="uni/title" size="30" value="<?php print $s->html( $data["data"]["title"] ); ?>">&nbsp;
							場所<input type="text" name="uni/place" size="24" value="<?php print $s->html( $data["data"]["place"] ); ?>"  style="width:100px;" >&nbsp;
						</td>
					</tr>
					<tr>
						<td class="normal" align="right" style="text-align: right;">
							時刻<?php echo $data['startTimeListbox'];?>～<?php echo $data['endTimeListbox'];?>
						</td>
						<td class="normal">
							ジャンル<?php echo $data['genreListbox']; ?>
						</td>
					</tr>

					<tr>

						<td colspan="2">
							<div class="hanrei">
								<?php echo $data['memberCheckbox'];?>
							</div>
						</td>

					</tr>

					<tr> 
						<td class="normal" colspan="2" style="text-align: left;">
							詳細：<br>
						</td> 
					</tr> 
					<tr> 
						<td class="normal" colspan="2" style="text-align: center;">
							<textarea name="uni/detail" cols="80" rows="10"><?php print $s->html( $data["data"]["detail"] ); ?></textarea> 
						</td> 
					</tr> 
					<tr> 
						<td colspan="2" align="center" class="normalgray"> 
						<input type="checkbox" name="uni/silent" value="1" <?php echo $data['silentchecked'];?>>ひっそり</td> 
					</tr> 
					<tr>
						<td colspan="2" class="normal" style="text-align: center;">
							<span class="ui-corner-all" style="padding: 4px; margin: 4px; width: 50%; text-align: center;">
							<?php echo $data['rdoChgType'] ?>
							</span>
							<input type="submit" value="変更" class="button">
							<a href="./index.php" value="キャンセル" class="button">キャンセル</a>
						</td>
					</tr>
				</table> 


				<br>
				<input type="hidden" value="01" name="fno"> 
				<input type="hidden" value="wrt" name="mode"> 
				<input type="hidden" value="20101210" name="cdate">
				<input type="hidden" name="uni/id" value="<?php print $data["data"]["id"]; ?>">
			</div>
		</div> 
	</div> 

</form>
