<?php
    ini_set( 'display_errors', 0 );
    date_default_timezone_set('Asia/Tokyo');
    require_once( "./config.php" );
    require_once( "cheetan/cheetan.php" );

function action( &$c )
{
	$c->SetViewFile( 'u_edit.html.php' );
    $conf = $c->d_conf->find("");
	$confdata = array();
	foreach($conf as $confone){
		$confdata[$confone['confkey']] = $confone['confvalue'];
	}
	$c->set("calname",$confdata['calname']);

	$errmsg = "";
	if( count( $_POST ) ){
		$errmsg = $c->d_data->validatemsg( $c->data["uni"]);
		if( $errmsg == "" ){
			if($c->data['uni']['silent']!=1){
				$c->data['uni']['silent'] = 0;
			}
			$c->data['uni']['startdate']=$c->data['uni']['year'].$c->data['uni']['month'].$c->data['uni']['day'];
			switch($c->data['uni']['starttime']){
				case "ALL1":
				case "ALL2":
				case "AM":
				case "PM":
					$c->data['uni']['vaguedate_f']=1;
					break;
				default:
					$c->data['uni']['vaguedate_f']=0;
			}

			$chkMemberStrArray = $c->data['uni']['member'];
			if(count($chkMemberStrArray)<1){
				$chkMemberStr = "";
			}else{
				$chkMemberStr = implode(",", $chkMemberStrArray);
			}
			$c->data['uni']['member']=$chkMemberStr;

			if(!isset($c->data['uni']['chgtype'])){
				$c->data['uni']['chgtype'] = "copy";
			}
			switch ($c->data['uni']['chgtype']){
				case "change":
					$c->data["uni"]["modified"] = date( "YmdHis" );
					$c->d_data->update( $c->data["uni"] );
					break;
				case "copy":
					$c->data["uni"]["modified"] = date( "YmdHis" );
					$insertData = array();
					$insertData = $c->data["uni"];
					$errmsg .= "<font color=red>".($maxID+1)."</font>";

					$c->d_data->insert( $c->data["uni"] );
					break;
				case "delete":
					$c->data["uni"]["modified"] = date( "YmdHis" );
					$c->d_data->del( '$id=='.$c->data["uni"]["id"] );
					break;
			}
			$c->redirect( "." );
		}
	}
	$errmsg.="".$c->data['uni']['chgtype']."<br><br>";
	$c->set( "errmsg", $errmsg );

	if(isset( $_GET['id'])){
		$getID = $c->sanitize->html($_GET["id"]);
		$c->set( "data", $c->d_data->findone( '$id==' . $getID ) );
		$data2 = $c->d_data->findone( '$id==' . $getID );

		$selectedYear  = substr($data2["startdate"] ,0,4);
		$selectedMonth = substr($data2["startdate"] ,4,2);
		$selectedDay   = substr($data2["startdate"] ,6,2);

		$selectedStartTime = $data2["starttime"];
		$selectedEndTime   = $data2["endtime"];
		$checkedMember = explode(",",$data2["member"]);
		
		$selectedGenre = $data2["genre"];
		if($data2["silent"]==1){
			$c->set( 'silentchecked' ,'CHECKED');
		}else{
			$c->set( 'silentchecked' ,'');
		};
		$dispChgType = true;
	}else{
		if(isset($_GET['n'])){
			$err = "";
			$getNewDate = $c->sanitize->html($_GET["n"]);
			$err .= $c->v->number( $getNewDate, 'wrong Number.' );
			$err .= $c->v->len( $getNewDate, 8,'wrong Length.' );
			if($err == ""){
				$selectedYear  = substr($getNewDate ,0,4);
				$selectedMonth = substr($getNewDate ,4,2);
				$selectedDay   = substr($getNewDate ,6,2);
				$selectedStartTime = '';
				$selectedEndTime   = '';
				$checkedMember = array();
				$selectedGenre = '';
				$dispChgType = false;
			}else{
				$c->redirect( "." );
			}
		}else{
			$selectedYear  = '';
			$selectedMonth = '';
			$selectedDay   = '';

			$selectedStartTime = '';
			$selectedEndTime   = '';
			$checkedMember = array();
			$selectedGenre = '';
			$dispChgType = false;
		}
	}

	$c->set( 'startTimeListbox' , $c->unicom->makeStartTimeListbox($selectedStartTime));
	$c->set( 'endTimeListbox' , $c->unicom->makeEndTimeListbox($selectedEndTime));
	$c->set( 'yearListbox' , $c->unicom->makeYearListbox($selectedYear));
	$c->set( 'monthListbox' , $c->unicom->makeMonthListbox($selectedMonth));
	$c->set( 'dayListbox' , $c->unicom->makeDayListbox($selectedDay));

	$member = $c->d_member->find('','dispid ASC');
	$c->set( 'memberCheckbox' , $c->unicom->makeMemberCheckBoxes($member,$checkedMember,1));
	$c->set( 'memberTextList' , $c->unicom->makeMemberCheckBoxes($member,$checkedMember,2));

	$genreList = $c->d_genre->find('','dispid ASC');
	$c->set( 'genreListbox' , $c->unicom->makeGenreListbox($genreList,$selectedGenre,1));
	$c->set( 'genreListMono' , $c->unicom->makeGenreListbox($genreList,$selectedGenre,1));

	$c->calendar->Calendar();
	$c->set( 'calendar' ,$c->calendar->getCalendar());
	$c->set( 'rdoChgType' ,$c->unicom->makeRdoChgType($dispChgType));
}
?>