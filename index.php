<?php
    ini_set( 'display_errors', 0 );
    date_default_timezone_set('Asia/Tokyo');
    require_once( "config.php" );
	require_once( "cheetan/cheetan.php" );

function action( &$c )
{
	$c->SetViewFile( "u_index.html.php" );
	$conf = $c->d_conf->find("");
	$confdata = array();
	foreach($conf as $confone){
		$confdata[$confone['confkey']] = $confone['confvalue'];
	}
	$c->set("calname",$confdata['calname']);


	$member = $c->d_member->find('','dispid ASC');
	$c->set("member",$member);

	//休日データの読み込み
	//通常祭日
	$holiday_temp = $c->d_holiday->find('','holidaydate ASC');
	$holiday = array();
	foreach($holiday_temp as $holiday_tempOne){
		$holiday[$holiday_tempOne['holidaydate']] = $holiday_tempOne['title'];
	}
	//固定日
	$holiday_static_temp = $c->d_holiday_static->find('','mmdd ASC');
	$holiday_static = array();
	foreach($holiday_static_temp as $holiday_static_tempOne){
		$holiday_static[$holiday_static_tempOne['mmdd']] = $holiday_static_tempOne['title'];
	}

	$selectedYear  = '';
	$selectedMonth = '';
	$selectedDay   = '';

	$selectedStartTime = '';
	$selectedEndTime   = '';
	$checkedMember = array();
	$selectedGenre = '';

	$c->set( 'startTimeListbox' , $c->unicom->makeStartTimeListbox($selectedStartTime));
	$c->set( 'endTimeListbox' , $c->unicom->makeEndTimeListbox($selectedEndTime));
	$c->set( 'yearListbox' , $c->unicom->makeYearListbox($selectedYear));
	$c->set( 'monthListbox' , $c->unicom->makeMonthListbox($selectedMonth));
	$c->set( 'dayListbox' , $c->unicom->makeDayListbox($selectedDay));



	$c->set( 'memberCheckbox' , $c->unicom->makeMemberCheckBoxes($member,$checkedMember,1));
	$c->set( 'memberTextList' , $c->unicom->makeMemberCheckBoxes($member,$checkedMember,2));
	$c->set( 'memberTextList2' , $c->unicom->makeMemberCheckBoxes($member,$checkedMember,3));

	$genreList = $c->d_genre->find('','dispid ASC');
	$c->set( 'genreListbox' , $c->unicom->makeGenreListbox($genreList,$selectedGenre,1));
	$c->set( 'genreListMono' , $c->unicom->makeGenreListbox($genreList,$selectedGenre,1));

	$c->set( 'confdata' , $confdata);

	$c->calendar->Calendar();
	$c->set( 'calendar' ,$c->calendar->getCalendar());
	
	$selectedStartTime = $data2["starttime"];


//--------------
	$weekStrArrayList = Array("日","月","火","水","木","金","土","日","月","火","水","木","金");
	$weekCSSArrayList = Array(   0,   1,   1,   1,   1,   1,   6,   0,   1,   1,   1,   1,   1);
	$weekNumArrayList = Array(   0,   1,   2,   3,   4,   5,   6,   0,   1,   2,   3,   4,   5);
	$monthCalc = Array(12, 1, 2, 3, 4, 5, 6, 7, 8, 9,10,11,12, 1);
	$yearCalc  = Array(-1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
	$monthNaviCalc = Array( 1, 2, 3, 4, 5, 6, 7, 8, 9,10,11,12, 1, 2, 3, 4, 5, 6, 7, 8, 9,10,11);
	$yearNaviCalc = Array(  0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

	$dispWeekNum = 6;
	if(count($_GET)){
		$err = '';
		$d = $c->s->get('d');
		$y = $c->s->get('y');
		if($y != ""){
			$d = $y."0101";
			$dispWeekNum = 54;
		}

		$err .= $c->v->number( $d, 'wrong Number.' );
		$err .= $c->v->len( $d, 8,'wrong Length.' );
		if($err == ""){
			$tmpYYYY= substr($d,0,4);
			$tmpMM  = substr($d,4,2);
			$tmpDD  = substr($d,6,2);
			$targetDate = mktime(0, 0, 0, $tmpMM, $tmpDD, $tmpYYYY);
		}else{
			$targetDate = time();
		}
	}else{
		$targetDate = time();
	}

	$c->set('errmsg', $errmsg);



	$YYYY = date('Y', $targetDate);
	$MM = date('m', $targetDate);
	$DD = date('d', $targetDate);
	$YYYYMMDD = $YYYY.$MM.$DD;
	$firstDayofWeek = $c->unicom->getFirstDayOfWeek($YYYYMMDD, $confdata['monorsun']);
	$targetDate = $firstDayofWeek;
	$c->set('targetDate' , $targetDate);

	//MonthNavi
	$monthNavi = array();
	$nowYYYY = date('Y',time());
	for($i=$confdata['monthnavistartmonth'];$i<($confdata['monthnavistartmonth']+12);$i++){
		$monthNavi[] = ($nowYYYY+$yearNaviCalc[$i-1]).sprintf("%02d",$monthNaviCalc[$i-1])."01";
	}
	$c->set('monthNavi' , $monthNavi);

	//PrevMonth
	$PrevMonth = sprintf("%02d",$monthCalc[$MM-1]);
	$PrevMonthYear = $YYYY+$yearCalc[$MM-1];
	$PrevMonthStr = $PrevMonthYear.$PrevMonth."01";
	$c->set('prevMonth' , $PrevMonthStr);

	//NextMonth
	$NextMonth = sprintf("%02d",$monthCalc[$MM+1]);
	$NextMonthYear = $YYYY+$yearCalc[$MM+1];
	$NextMonthStr = $NextMonthYear.$NextMonth."01";
	$c->set('nextMonth' , $NextMonthStr);

	//PrevWeek
	$PrevWeekDate = strtotime("-7 day",$targetDate);
	$PrevWeekYYYY = date('Y', $PrevWeekDate);
	$PrevWeekMM = date('m', $PrevWeekDate);
	$PrevWeekDD = date('d', $PrevWeekDate);
	$PrevWeekStr = $PrevWeekYYYY.$PrevWeekMM.$PrevWeekDD;
	$c->set('prevWeek' , $PrevWeekStr);

	//NextWeek
	$NextWeekDate = strtotime("+7 day",$targetDate);
	$NextWeekYYYY = date('Y', $NextWeekDate);
	$NextWeekMM = date('m', $NextWeekDate);
	$NextWeekDD = date('d', $NextWeekDate);
	$NextWeekStr = $NextWeekYYYY.$NextWeekMM.$NextWeekDD;
	$c->set('nextWeek' , $NextWeekStr);

	$weekStrArray = array();
	$weekNumArray = array();
	for($i=0;$i<7;$i++){
		$weekStrArray[$i] = $weekStrArrayList[$i+$confdata['monorsun']];
		$weekNumArray[$i] = $weekNumArrayList[$i+$confdata['monorsun']];
		$weekCSSArray[$i] = "weektd_".$weekCSSArrayList[$i+$confdata['monorsun']];
	}
	$c->set('weekStrArray' , $weekStrArray);
	$c->set('weekNumArray' , $weekNumArray);
	$c->set('weekCSSArray' , $weekCSSArray);

	$c->set('dispWeekNum' , $dispWeekNum);
	
	$dayAdd = 0;
	$theDayDatas = array();
	$theDays = array();
	$theWeekTypes = array();
	$theDaysforDisp = array();
	$theDaysWeekDisp = array();

    $simpleMemberArray = array();
    if(count($member)!=0){
        foreach($member as $memberOne){
            $simpleMemberArray[$memberOne['id']] = Array(
                dispid => $memberOne['dispid'],
                memname1 => $memberOne['memname1'],
                memname2 => $memberOne['memname2'],
                memname3 => $memberOne['memname3'],
                color => $memberOne['color'],
                icon => $memberOne['icon'],
                f_small => $memberOne['f_small'],
                f_disp => $memberOne['f_disp'],
                opt1 => $memberOne['opt1'],
                opt2 => $memberOne['opt2'],
                opt3 => $memberOne['opt3']
            );
        }
    }

	for($i=0;$i<$dispWeekNum;$i++){
		for($j=0;$j<7;$j++){
			$plus = "+".$dayAdd." day";
			$thaDay = strtotime($plus,$targetDate);
			$theYYYY = date('Y', $thaDay);
			$theMM = date('m', $thaDay);
			$theDD = date('d', $thaDay);
			$theW = date('w', $thaDay);
			$theYYYYMMDD = $theYYYY.$theMM.$theDD;
			$theMMDD = $theMM.$theDD;




			$theDayDatas = $c->d_data->find( '$startdate=='.$theYYYYMMDD, "starttime ASC");





			$counter = 0;
			foreach($theDayDatas as $theDayDataOne){
				$memberData = array();
				$theOneDayDataTemp = array();
				if($theDayDataOne['member'] != ""){
					$checkedMember = explode(",",$theDayDataOne['member']);
				}else{
					$checkedMember = Array();
				}
				$memNameString = "";
				if(count($checkedMember)!=0){
					foreach($checkedMember as $checkedMemberOne){
						$memberData[] = $simpleMemberArray[$checkedMemberOne];
					}
					$theDayDataOne['memberData'] = $memberData;
				}

				//時刻を可読文字に変換
				//開始時刻
				if(is_numeric($theDayDataOne['starttime'])){
					$startHour = substr($theDayDataOne['starttime'],0,2)+0;
					$startMin  = substr($theDayDataOne['starttime'],2,2);
					$startTimeDisp = $startHour.":".$startMin;
				}else{
					switch($theDayDataOne['starttime']){
						case "ALL1":
							$startTimeDisp = "";
							$theDayDataOne['starttime']="0830";
							break;
						case "ALL2":
							$startTimeDisp = "";
							$theDayDataOne['starttime']="0830";
							break;
						case "AM":
							$startTimeDisp = "午前";
							$theDayDataOne['starttime']="0830";
							break;
						case "PM":
							$startTimeDisp = "午後";
							$theDayDataOne['starttime']="1300";
							break;
						default:
							$startTimeDisp = "";
					}
				}
				$theDayDataOne['startTimeDisp'] = $startTimeDisp;
				//終了時刻
				if($theDayDataOne['endtime']!=""){
					$endHour = substr($theDayDataOne['endtime'],0,2)+0;
					$endMin = substr($theDayDataOne['endtime'],2,2);
					$endTimeDisp = $endHour.":".$endMin;
					$theDayDataOne['endTimeDisp'] = $endTimeDisp;
				}else{
					$theDayDataOne['endTimeDisp'] = "";
				}

				$theDayDataOne['genreData'] = $genreList[$theDayDataOne['genre']-1];

				//出力データのセット
				//----------------------------------------------------------------------------
				$theDayDataAll[$theYYYYMMDD][$counter] = $theDayDataOne;
				//----------------------------------------------------------------------------
				$counter++;
			}
			
			//sort proccess is not implemented yet!
			//write here

			//祝日の判定
			$holiday_f = 0;
			$holiday_title = array();
			if($holiday_static[$theMMDD]['title']!=""){
				$holiday_title[] = $holiday_static[$theMMDD];
				$holiday_f = 1;
			}
			if($holiday[$theYYYYMMDD]['title']!=""){
				$holiday_title[] = $holiday[$theYYYYMMDD];
				$holiday_f = 1;
			}
			$holidayTitles[] = $holiday_title;

			//日ごと出力データの生成（曜日，祝日判定）
			switch($theW){
				case 0:
					$theWeekType = "datesun";
					break;
				case 6:
					if($holiday_f == 1){
						$theWeekType = "datesun";
					}else{
						$theWeekType = "datesat";
					}
					break;
				default:
					if($holiday_f == 1){
						$theWeekType = "datesun";
					}else{
						$theWeekType = "datenormal";
					}
			}
			$theDays[] = $theYYYYMMDD;
			$theWeekTypes[] = $theWeekType;
			if($lastMonth != $theMM){
				$theDaysforDisp[] = $theYYYY."/".$theMM."/".$theDD;
			}else{
				$theDaysforDisp[] = $theDD;
			}

			$lastMonth = $theMM;
			$dayAdd++;
		}
	}
	
	$footerNaviStr = $c->unicom->makeFooterNaviStr($confdata['startyear'],$confdata['endyear']);

	$c->set('theDaysforDisp' , $theDaysforDisp);
	$c->set('theDays' , $theDays);
	$c->set('theWeekTypes' , $theWeekTypes);
	$c->set('dayData' , $theDayDataAll);
	$c->set('holidayTitles' , $holidayTitles);
	$c->set('footerNaviStr' , $footerNaviStr);
}


?>