<script language="JavaScript">
$(function() {
	$(".navi_icon").button();
	$(".navibutton").button();

});
</script>
<?php echo $data['errmsg'];?>
<span class="forprint">
	<div class="hanrei2"> 
		<?php echo $data['memberTextList'];?>
	</div>
</span> 
<div class="alert"></div> 
<form action="u_edit.php" method="post"> 
	<div id="header1"> 
		<div class="text ui-widget-content ui-corner-all" style="padding: 10px;">
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
					<td rowspan="3" class="normal">
						<input type="submit" value="追加" class="button">
					</td>
				</tr>
				<tr>
					<td class="normal">
						時刻<?php echo $data['startTimeListbox'];?>～<?php echo $data['endTimeListbox'];?>
					</td>
					<td class="normal">
						ジャンル<?php echo $data['genreListbox']; ?>
					</td>
				</tr>
				<tr>
					<td class="normal" colspan="2">
						<div class="hanrei">
								<?php echo $data['memberCheckbox'];?>
						</div>
					</td>
				</tr>
			</table>
		</div> 
	</div> 

	<div class="navi"> 
		<div class="size1">

<!--
		<span class="navi_icon" style="font-size:90%;"><span class="ui-icon ui-icon-arrowthick-1-e" style="float:left; margin: auto;"></span><a href="./index.php">今週</a></span>&nbsp&nbsp;
		<span class="navi_icon" style="font-size:90%;"><span class="ui-icon ui-icon-arrowthick-1-n" style="float:left; margin: auto;"></span><a href="./index.php?d=<?php echo($data['prevMonth']); ?>">前月</a></span>&nbsp;
		<span class="navi_icon" style="font-size:90%;"><span class="ui-icon ui-icon-triangle-1-n" style="float:left; margin: auto;"></span><a href="./index.php?d=<?php echo($data['prevWeek']); ?>">前の週</a></span>&nbsp;
		<span class="navi_icon" style="font-size:90%;"><span class="ui-icon ui-icon-triangle-1-s" style="float:left; margin: auto;"></span><a href="./index.php?d=<?php echo($data['nextWeek']); ?>">次の週</a></span>&nbsp;
		<span class="navi_icon" style="font-size:90%;"><span class="ui-icon ui-icon-arrowthick-1-s" style="float:left; margin: auto;"></span><a href="./index.php?d=<?php echo($data['nextMonth']); ?>">次月</a></span>&nbsp;
-->

		<a href="./index.php" class="navibutton" style="font-size: 90%;">今週</a>&nbsp&nbsp;
		<a href="./index.php?d=<?php echo($data['prevMonth']); ?>" class="navibutton" style="font-size: 90%;">&lt;&lt;&nbsp;前月</a>&nbsp;
		<a href="./index.php?d=<?php echo($data['prevWeek']); ?>" class="navibutton" style="font-size: 90%;">&lt;&nbsp;前の週</a>&nbsp;
		<a href="./index.php?d=<?php echo($data['nextWeek']); ?>" class="navibutton" style="font-size: 90%;">次の週&nbsp;&gt;</a>&nbsp;
		<a href="./index.php?d=<?php echo($data['nextMonth']); ?>" class="navibutton" style="font-size: 90%;">次月&nbsp;&gt;&gt;</a>&nbsp;
		</div> 
	</div> 
	<span class="monthNavi">
		<?php
			$lastYear = 0;
			for($i=0;$i<12;$i++){
				if($lastYear != substr($data["monthNavi"][$i],0,4)){
					echo("<span class='silent'>".substr($data["monthNavi"][$i],0,4)."</span>&nbsp;&nbsp;");
				}
				
				echo("<a href='./index.php?d=".$data["monthNavi"][$i]."'>".substr($data["monthNavi"][$i],4,2)."</a>&nbsp;&nbsp;\n");
				
				$lastYear = substr($data["monthNavi"][$i],0,4);
			}
		?>
	</span>

	<table border="0" class="calendar1" cellspacing="0"> 
		<tr> 
	<?php
		for($i=0;$i<7;$i++){
			echo("<td width='100' class='".$data["weekCSSArray"][$i]."'><div class='week'>");
			echo($data["weekStrArray"][$i]);
			echo("</div></td>\n");
		}
	?>
		</tr> 

	<?php
		$dayAdd1 = 0;
		$dayAdd2 = 0;
		for($i=0;$i<$data['dispWeekNum'];$i++){
			echo("<tr>\n");
			for($j=0;$j<7;$j++){
				$theYYYYMMDD = $data['theDays'][$dayAdd1];
				echo("<td width='100'>\n");
					//日付
				echo("<div class='".$data['theWeekTypes'][$dayAdd1]."'>");
				echo("\t<a href='./u_edit.php?n=".$data['theDays'][$dayAdd1]."'>");
				echo($data['theDaysforDisp'][$dayAdd1]);
				echo("</a>\n");
				echo("</div>\n");


				//祝日表示
				if(count($data['holidayTitles'][$dayAdd1])){
					echo("<span class='holiday'>");
					foreach($data['holidayTitles'][$dayAdd1] as $holidayTitle){
						echo($holidayTitle."<br>");
					}
					echo("</span>");
				}

				$counter = 0;
				$OutputHtml = "";

				for($k=0;$k<count($data['dayData'][$theYYYYMMDD]);$k++){
					$OutputHtml .= "<div class='ondayevent' style='background-color: #".$data['dayData'][$theYYYYMMDD][$k]['genreData']['color'].";'>";
					$OutputHtml .= "<span class='c1'>";
					$OutputHtml .= "<a class='c2' href='u_edit.php?id=".$data['dayData'][$theYYYYMMDD][$k]['id']."'";

					$tempGenre = $data['dayData'][$theYYYYMMDD][$k]['genreData']['genrename'];
					if($tempGenre != ""){
						$OutputHtml .= " title='".$data['dayData'][$theYYYYMMDD][$k]['genreData']['genrename']."'";
					}
					$OutputHtml .= ">";

					//開始時刻
					$OutputHtml .= $data['dayData'][$theYYYYMMDD][$k]['startTimeDisp'];


					//終了時刻
					if($data['dayData'][$theYYYYMMDD][$k]['endtime']!=""){
						$OutputHtml .= "-";
						$OutputHtml .= $data['dayData'][$theYYYYMMDD][$k]['endTimeDisp']." ";
					}
					if(($data['dayData'][$theYYYYMMDD][$k]['startTimeDisp']!="")||($data['dayData'][$theYYYYMMDD][$k]['endTimeDisp']!="")){
						$OutputHtml .= "<br>";
					}

					$OutputHtml .= " ";

					//予定題名
					$OutputHtml .= $data['dayData'][$theYYYYMMDD][$k]['title'];

					//場所
					if($data['dayData'][$theYYYYMMDD][$k]['place']!=""){
						$OutputHtml .= "(".$data['dayData'][$theYYYYMMDD][$k]['place'].")";
					}
					
					$OutputHtml .= "</a>\n";
					//メンバー
					if(count($data['dayData'][$theYYYYMMDD][$k]['memberData'])){
						foreach($data['dayData'][$theYYYYMMDD][$k]['memberData'] as $memberDataOne){
						//	$OutputHtml .= "<a href='#' title='".$memberDataOne['memname1']."'><span class='member' style='color: #".$memberDataOne['color'].";'>■</span></a>";
							$OutputHtml .= "<a href='#' title='".$memberDataOne['memname1']."'><span class='member' style='color: #".$memberDataOne['color'].";font-weight: bold;'>[".$memberDataOne['memname3']."]</span></a>";

						}
					}
					$OutputHtml .= "</span>";
					$OutputHtml .= "</div>";
					
				}
				echo($OutputHtml);
				echo("</td>\n");
				$dayAdd1++;
			}
			echo("</tr>\n");
		}
	?>
	</table>

	<div class="footer">
		<?php echo($data['footerNaviStr']); ?>
		<br> 
		<div class="hanrei2">
			<?php echo($data['memberTextList2']); ?>
		</div> 
	</div> 
</form>
