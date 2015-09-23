<?php 
class unicom{

	function makeStartTimeListbox($selected = 'ALL1', $timespan = 0){
		$ALL1 = "(未定)";
		$ALL2 = "終日";
		$AM   = "午前";
		$PM   = "午後";

		$listbox = array();
		$listbox = $this->timeArray($timespan); //$timespan 0:30min 1:15min
		array_unshift($listbox, Array("ALL1",$ALL1), 
								Array("ALL2",$ALL2), 
								Array("AM",$AM), 
								Array("PM",$PM)
		);
		$listBoxStr = "<select name='uni/starttime'>\n";
		
		foreach($listbox as $s){
			$listBoxStr .= "<option value='".$s[0]."'";
			if($selected == $s[0]){
				$listBoxStr.=" SELECTED";
			}
			$listBoxStr.= ">".$s[1]."</option>\n";
		}
		$listBoxStr .="</select>\n";
		return $listBoxStr;
	}

	function makeEndTimeListbox($selected = '', $timespan = 0){
		$listbox = array();
		$listbox = $this->timeArray($timespan); //$timespan 0:30min 1:15min
		array_unshift($listbox, Array("","---"));
		$listBoxStr = "<select name='uni/endtime'>\n";
		
		foreach($listbox as $s){
			$listBoxStr .= "<option value='".$s[0]."'";
			if($selected == $s[0]){
				$listBoxStr.=" SELECTED";
			}
			$listBoxStr.= ">".$s[1]."</option>\n";
		}
		$listBoxStr .="</select>\n";
		return $listBoxStr;
	}


	function timeArray($timespan = 0){
		$timeArray = array();
		$startHour = 5; //(0-23)
		$endHour   = 24;//(1-24)
		
		for($i=$startHour;$i<=$endHour;$i++){
			if($timespan == 1){
				$timeArray[]  = Array( sprintf("%02d",$i)."00", sprintf("%02d",$i).":00");
				$timeArray[]  = Array( sprintf("%02d",$i)."15", sprintf("%02d",$i).":15");
				$timeArray[]  = Array( sprintf("%02d",$i)."30", sprintf("%02d",$i).":30");
				$timeArray[]  = Array( sprintf("%02d",$i)."45", sprintf("%02d",$i).":45");
			}else{
				$timeArray[]  = Array( sprintf("%02d",$i)."00", sprintf("%02d",$i).":00");
				$timeArray[]  = Array( sprintf("%02d",$i)."30", sprintf("%02d",$i).":30");
			}
		}
		return $timeArray;
	}


	function makeMonthListbox($selected=0){
		if($selected == 0){ $selected = date("m");}
			
		$listBoxStr = "<select name='uni/month'>\n";
		for($i=1;$i<=12;$i++){
			$listBoxStr .= "<option value='".sprintf("%02d",$i)."'";
			if($selected == $i){
				$listBoxStr.=" SELECTED";
			}
			$listBoxStr.= ">".$i."</option>\n";
		}
		$listBoxStr .="</select>\n";
		return $listBoxStr;
	}


	function makeDayListbox($selected=0, $targetdate = ""){
		if($selected == 0){ $selected = date("d");}
		if($targetdate == ""){
			$targetdate = time();
		}
//		$endDay = date('t', $targetdate);
		$endDay = 31;

		$listBoxStr = "<select name='uni/day'>\n";
		for($i=1;$i<=$endDay;$i++){
			$listBoxStr .= "<option value='".sprintf("%02d",$i)."'";
			if($selected == $i){
				$listBoxStr.=" SELECTED";
			}
			$listBoxStr.= ">".$i."</option>\n";
		}
		$listBoxStr .="</select>\n";
		return $listBoxStr;
	}

	function makeYearListbox($selected=0, $startYear=0, $endYear=0){
		if($selected == 0){ $selected = date("Y");}
		if($startYear == 0){$startYear = date("Y")-2;}
		if($endYear == 0){$endYear = date("Y")+2;}
			
		$listBoxStr = "<select name='uni/year'>\n";
		for($i=$startYear;$i<=$endYear;$i++){
			$listBoxStr .= "<option value='".$i."'";
			if($selected == $i){
				$listBoxStr.=" SELECTED";
			}
			$listBoxStr.= ">".$i."</option>\n";
		}
		$listBoxStr .="</select>\n";
		return $listBoxStr;
	}

	function makeMemberCheckBoxes($memberList, $checked, $type=1){ //$memberList, $memberListKey, $checkd: Array, $type: 1:NormalCheckboxes 2:textList 3:SimpleTextList
		$checkboxStr="";
		$textListStr="";
		$textListStr2="";
		foreach($memberList as $memberID => $memberListOne){

//		for($i=0;$i<count($memberList);$i++){
			$checkedID = "";
			foreach($checked as $checkedMember){
				if($memberListOne['id'] == $checkedMember){ //key
					$checkedID = $checkedMember;
				}
			}
			if($checkedID != ""){
				$checkedStr = " CHECKED";
			}else{
				$checkedStr = "";
			}

			if($memberListOne['f_disp']=='true'){
                $checkboxStr .= '<span style="height: 1.2em; width: 1em; vertical-align: middle; padding: 0 0 0 0; background-color:#'. $memberListOne['color'].'; margin: 4px;">';
				$checkboxStr .= '<input type="checkbox" name="uni/member[]" style="#'. $memberListOne['color'].'; outline: 4px solid #'. $memberListOne['color'].'; padding: 0; background-color:#'. $memberListOne['color'].'; text-align: center; vertical-align: middle; height: auto; width: auto;" value="'.$memberListOne['id'].'"'.$checkedStr.'>';
				$checkboxStr .= '</span>';

                $checkboxStr .= $memberListOne['memname2']."\n";

				$textListStr .= '<span style="color:#'.$memberListOne['color'].';">■</span>';
				$textListStr .= '['.$memberListOne['memname3'].']';
				$textListStr .= $memberListOne['memname2']."\n";
				$textListStr2 .= '<span style="color:#'.$memberListOne['color'].';">■</span>';
				$textListStr2 .= $memberListOne['memname2']."\n";
			}
		}

		switch ($type){
			case 1:
				$returnStr = $checkboxStr;
				break;
			case 2:
				$returnStr = $textListStr;
				break;
			case 3:
				$returnStr = $textListStr2;
				break;
			default:
		}
		return $returnStr;
	}

	function makeGenreListbox($genreList, $selected="", $type=1){ //type: 1:Listbox 2:textList(color) 3:textList(color)
		switch($type){
			case 1:
				$HeaderStr = "[集計]";
				$NonGenre = "無分類";
				$listStr = "<select name='uni/genre'>\n";
				$listStr .= "<option value='000'>".$NonGenre."</option>\n";
				for($i=0;$i<count($genreList);$i++){
					if($genreList[$i]['f_disp']==1){
						$listStr .= "<option value='".$genreList[$i]['id']."'";
						if($selected == $genreList[$i]['id']){
							$listStr.=" SELECTED";
						}
						$listStr.= " style='background-color:".$genreList[$i]['color']."'>";
						if($genreList[$i]['f_calc']==1){
							$listStr .= $HeaderStr;
						}
						$listStr.=$genreList[$i]['genrename']."</option>\n";
					}
				}
				$listStr .="</select>\n";
				break;
			case 2:
				//not yet
				break;
			case 3:
				//not yet
				break;
		}
		return $listStr;
	}

	function makeRdoChgType($dispChgType = false){
		if($dispChgType){
			$chgStr = "変更";
			$copyStr = "複製";
			$delStr = "削除";
			$rdoStr = "<input type='radio' name='uni/chgtype' value='change' CHECKED>".$chgStr."<input type='radio' name='uni/chgtype' value='copy'>".$copyStr."<input type='radio' name='uni/chgtype' value='delete'>".$delStr;
		}else{
			$rdoStr = "";
		}
		return $rdoStr;

	}

	//週の初めの日付を返す
	function getFirstDayOfWeek($YYYYMMDD, $monorsun = 0){ //monorsun: 0:Sunday 1:Monday
		$weekNumArrayList = Array(0,1,2,3,4,5,6,0,1,2,3,4,5);
		$YYYY=substr($YYYYMMDD,0,4);
		$MM=substr($YYYYMMDD,4,2);
		$DD=substr($YYYYMMDD,6,2);
		$targetDate = mktime(0, 0, 0, $MM, $DD, $YYYY);
		$w = date('w',$targetDate);
		if($w == $monorsun){
			$firstDayOfWeek = $targetDate;
		}else{
			if($monorsun > $w){
				$back = 7;
			}
			$minus = ($monorsun-$w-$back)." day";
			$firstDayOfWeek = strtotime($minus,$targetDate);
		}
		return $firstDayOfWeek;
	}

	function makeFooterNaviStr($startyear,$endyear){
		$outputStr = "<div class='monthnavi'>";
		for($i=$startyear;$i<=$endyear;$i++){
			$outputStr .= "<a href='index.php?y=".$i."'>".$i."年</a>&nbsp;";
			for($j=1;$j<=12;$j++){
				$outputStr .= "<a href='index.php?d=".$i.sprintf("%02d",$j)."01'>".$j."月</a>&nbsp;";
			}
			$outputStr .= "<br>";
		}
		$outputStr .= "</div>";
		return $outputStr;
	}
    
    function makeCSVforGoogleCalendar($startdate,$enddate){
        //Subject,Start Date,Start Time,End Date,End Time,All Day Event,Description,Location,Private
        //期末試験,05/12/20,07:10:00 PM,05/12/07,10:00:00 PM,False,"小論文問題（2,000 字）",614 教室,True
        
        
    }

}
?>