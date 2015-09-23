<?php
/*
 * CalendarClass.php
 *  Copyright 2007- Akihiro Asai. All rights reserved.
 *
 *  http://aki.adam.ne.jp/
 *   aki@ullr.cc
 */

/*
 * 2008/10/12 - v0.10 by T.NISHIHARA
 */

class Calendar {

/*
<style type="text/css">
table.calendar {margin:0;margin-left:-5px;padding:0;border-collapse:collapse;border-spacing:0;empty-cells:show;border:none;}
table.calendar caption {margin:0;padding:0;text-align:center;font-weight:bold;}
table.calendar th {padding:0;text-align:center;color:#030;border:none;}
table.calendar td {padding:1px 2px;text-align:right;vertical-align:top;color:#000;border:none;}
table.calendar td.large {width:50px;height:50px;}
table.calendar .today {font-weight:bold;color:#c00;border:1px solid #808080;}
table.calendar .holiday {font-size:70%;text-align:left;}
table.calendar .bgweekname {background-color:#eee;}
table.calendar .bgholiday {background-color:#fdd;}
table.calendar .bgweekday {background-color:#fff;}
table.calendar .bgsaturday {background-color:#ddf;}
table.calendar .bgotherday {background-color:#eee;}
</style>

	$parms = array(
		'baseUrl'		=> '',
		'queryStr'		=> 'date',
		'prevLink'		=> '&lt;',
		'nextLink'		=> '&gt;',
		'styleTable'	=> 'calendar',
		'styleGrid'		=> '',
		'styleToday'	=> 'today',
		'styleHoliday'	=> 'holiday',
		'bgWeekname'	=> 'bgweekname',
		'bgWeekday'		=> 'bgweekday',
		'bgSaturday'	=> 'bgsaturday',
		'bgHoliday'		=> 'bgholiday',
		'bgOtherday'	=> 'bgotherday',
	);
	$weekname = array('日', '月', '火', '水', '木', '金', '土');
	$calendar = new Calendar( $params );
	echo $calendar->getCalendar();

*/

	// リンクのURL
	// @var string
	var $baseUrl		= '';

	// クエリー文字列
	// @var string
	var $queryStr		= 'date';

	// 前月へのリンク文字
	// @var string
	var $prevLink		= '&lt;';

	// 翌月へのリンク文字
	// @var string
	var $nextLink		= '&gt;';

	// カレンダーの全体スタイル
	// @var string
	var $styleTable		= 'calendar';

	// グリッドのスタイル
	// @var string
	var $styleGrid		= '';

	// 当日の表示スタイル
	// @var string
	var $styleToday		= 'today';

	// 休日名の表示スタイル
	// @var string
	var $styleHoliday	= 'holiday';

	// 背景色:曜日名
	// @var string
	var $bgWeekname		= 'bgweekname';
	// 背景色:平日
	// @var string
	var $bgWeekday		= 'bgweekday';
	// 背景色:土曜日
	// @var string
	var $bgSaturday		= 'bgsaturday';
	// 背景色:日祝日
	// @var string
	var $bgHoliday		= 'bgholiday';
	// 背景色:当月以外の日
	// @var string
	var $bgOtherday		= 'bgotherday';

	// 曜日名部分の文字列
	// @var array
	var $weekname		= array('日', '月', '火', '水', '木', '金', '土');

	// データ表示用
	// @var array
	var $_data			= array();

	// リンク設定用
	// @var array
	var $_link			= array();


	// コンストラクタ
	// @param	array	$params		リンクやCSSスタイルの設定
	// @param	array	$weekname	曜日の文字列
	// @return	void
	function __construct( $params = array(), $weekname = array() )
	{
		$this->initialize( $params, $weekname );
	}

	// コンストラクタ
	// @param	array	$params		リンクやCSSスタイルの設定
	// @param	array	$weekname	曜日の文字列
	// @return	void
	function Calendar( $params = array(), $weekname = array() )
	{
		return $this->__construct( $parms, $weekname );
	}

	// 初期設定
	// @param	array	$params		リンクやCSSスタイルの設定
	// @param	array	$weekname	曜日の文字列
	// @return	void
	function initialize( $params = array(), $weekname = array() )
	{
		if ( count( $params ) > 0 ) {
			foreach ( $params as $key => $val ) {
				if ( isset( $this->$key ) ) {
					$this->$key = $val;
				}
			}
		}
		if ( count( $weekname ) > 0 ) {
			$this->weekname = (array)$weekname;
		}
	}

	// カレンダーHTML文の取得
	// @param	integer	$year			年
	// @param	integer	$month			月
	// @param	integer	$week_start		カレンダーの開始曜日(0:日曜日～6:土曜日)
	// @param	bool	$disp_flg		当月以外の日の表示(0:表示しない 1:表示する)
	// @param	bool	$holiday_flg	祝日名の表示(0:表示しない 1:表示する)
	// @param	bool	$link_flg		カレンダー送りのリンク(0:表示しない 1:表示する)
	// @return	string
	function getCalendar( $year = 0, $month = 0, $week_start = 0, $disp_flg = TRUE, $holiday_flag = FALSE, $link_flag = FALSE )
	{
		// 年月のチェック
		if ( checkdate( $month, 1, $year ) === false ) {
			$year  = date( 'Y' );
			$month = date( 'm' );
		}
		$prev = date('Y-m', mktime( 0, 0, 0, $month-1, 1, $year ) );
		$next = date('Y-m', mktime( 0, 0, 0, $month+1, 1, $year ) );

		// 色設定用の配列を作成
		$bgcolor_weekname = array(
			$this->bgHoliday,
			$this->bgWeekname,
			$this->bgWeekname,
			$this->bgWeekname,
			$this->bgWeekname,
			$this->bgWeekname,
			$this->bgSaturday,
		);
		$bgcolor_body = array(
			$this->bgHoliday,
			$this->bgWeekday,
			$this->bgWeekday,
			$this->bgWeekday,
			$this->bgWeekday,
			$this->bgWeekday,
			$this->bgSaturday,
		);

		 // 休日情報を取得
		 $holiday = $this->getHoliday( $year, $month );

		// 曜日の開始位置を取得
		$from = 1;
		while ( date( 'w', mktime( 0, 0, 0, $month, $from, $year ) ) != $week_start ) {
			$from--;
		}

		$beforelast	= date( 't', mktime( 0, 0, 0, $month - 1, 1, $year ) ); // 前月最終日
		$thislast	= date( 't', mktime( 0, 0, 0, $month,     1, $year ) ); // 今月最終日
		$lpy = ceil( ( $thislast + abs( $from ) + 1 ) / 7 ); // Y方向ループ数

		// ----- HTML生成開始 -----
		$html = '';
		$html .= "<table class=\"{$this->styleTable}\" summary=\"カレンダー\">";

		// ヘッダ
		$html .= '<caption>';
		if ( $link_flag ) {
			$html .= "<a href=\"{$this->baseUrl}?{$this->queryStr}={$prev}\">{$this->prevLink}</a>&nbsp;&nbsp;";
		}
		$html .= sprintf( "%d年%d月", $year, $month );
		if ( $link_flag ) {
			$html .= "&nbsp;&nbsp;<a href=\"{$this->baseUrl}?{$this->queryStr}={$next}\">{$this->nextLink}</a>";
		}
		$html .= '</caption>';

		// 曜日
		$html .= '<tr>';
		for ( $i = 0; $i < 7; $i++ ) {
			$id = ( $week_start + $i ) % 7;
			$html .= "<th class=\"{$bgcolor_weekname[$id]}\">{$this->weekname[$id]}</th>";
		}
		$html .= '</tr>';

		for ( $i = 0; $i < $lpy; $i++ ) {

			$html .= '<tr>';

			for ( $j = 0; $j < 7; $j++ ) {

				$day = $i * 7 + $j + $from;

				// 背景色セット
				$id = ( $week_start + $j ) % 7;
				$bgcolor = $bgcolor_body[$id];

				if ( $day < 1 ) {
					// 指定月の前月
					$dd = $beforelast + $day;
					$data = $this->_getData($year, $month-1, $dd);
					$bgcolor = $this->bgOtherday;
				} else if( $day > $thislast ) {
					// 指定月の後月
					$dd = $day - $thislast;
					$data = $this->_getData($year, $month+1, $dd);
					$bgcolor = $this->bgOtherday;
				} else {
					// 指定月
					$dd = $day;
					$data = $this->_getData($year, $month, $dd);
					$link = $this->_getLink($year, $month, $dd);
					if($link != '') {
						$dd = "<a href=\"{$link}\">{$dd}</a>";
					}

					// 祝日の色変更処理
					if($holiday[$day] != '') {
						$bgcolor = $this->bgHoliday;
					}
				}

				// 当月以外の日付を表示しない
				if ( $disp_flg != 1 && ( $day < 1 || $day > $thislast ) ) {
					$dd = '<br />';
					$bgcolor = '';
					$data = '';
				}

				if ( sprintf('%04d%02d%02d', $year, $month, $day) == date('Ymd') ) {
					$html .= "<td class=\"{$this->styleGrid} {$bgcolor} {$this->styleToday}\">";
				} else {
					$html .= "<td class=\"{$this->styleGrid} {$bgcolor}\">";
				}
				$html .= "<span>{$dd}</span>";

				// 休日名出力用追加処理
				if ( $holiday_flag == 1 && $holiday[$day] != '' ) {
					$html .= "<div class=\"{$this->styleHoliday}\">{$holiday[$day]}</div>";
				}

				if ( $data != '' ) {
					$html .= $data;
				}
				$html .= '</td>';
			}

			$html .= '</tr>';

		}
		$html .= '</table>';

		return $html;
	}

	// 指定日付に表示文字を設定
	// @param	integer	$year	年
	// @param	integer	$month	月
	// @param	integer	$day	日
	// @param	string	$data	表示文字
	// @return	void
	function setData( $year, $month, $day, $data )
	{
		$id = sprintf( '%04d%02d%02d', $year, $month, $day );
		$this->_data[$id] = $data;
	}

	// 指定日付に表示リンクを設定
	// @param	integer	$year	年
	// @param	integer	$month	月
	// @param	integer	$day	日
	// @param	string	$link	表示リンク
	// @return	void
	function setLink( $year, $month, $day, $link )
	{
		$id = sprintf( '%04d%02d%02d', $year, $month, $day );
		$this->_link[$id] = $link;
	}


	// 指定日付よりデータを取得
	// @param	integer	$year	年
	// @param	integer	$month	月
	// @param	integer	$day	日
	// @return	string
	function _getData( $year, $month, $day )
	{
		$id = sprintf( '%04d%02d%02d', $year, $month, $day );
		if ( isset( $this->_data[$id] ) ) {
			return $this->_data[$id];
		}
		return '';
	}

	// 指定日付よりリンクを取得
	// @param	integer	$year	年
	// @param	integer	$month	月
	// @param	integer	$day	日
	// @return	string
	function _getLink( $year, $month, $day )
	{
		$id = sprintf( '%04d%02d%02d', $year, $month, $day );
		if ( isset( $this->_link[$id] ) ) {
			return $this->_link[$id];
		}
		return '';
	}

	// 指定年月の休日を取得
	// @param	integer	$year	年
	// @param	integer	$month	月
	// @return	array
	function getHoliday( $year, $month )
	{

		$ret = array();

		// その月の最初の月曜日が何日かを算出
		$day = 1;
		while ( date( 'w', mktime( 0 ,0 ,0 , $month, $day, $year ) ) != 1 ) {
			$day++;
		}

		// 祝日をセット
		switch( $month ) {
		case 1:
			// 元旦
			$ret[1] = '元旦';
			// 成人の日
			if ( $year < 2000 ) {
				$ret[15] = '成人の日';
			} else {
				$ret[$day+7] = '成人の日';
			}
			break;
		case 2:
			// 建国記念日
			$ret[11] = '建国記念日';
			break;
		case 3:
			// 春分の日
			if ( $year > 1979 && $year < 2100 ) {
				$tmp = floor( 20.8431 + ( $year - 1980 ) * 0.242194 - floor( ( $year - 1980 ) / 4 ) );
				$ret[$tmp] = '春分の日';
			}
			break;
		case 4:
			// 天皇誕生日 or みどりの日
			if ( $year < 1989 ) {
				$ret[29] = '天皇誕生日';
			} else if ( $year < 2007 ) {
				$ret[29] = 'みどりの日';
			} else {
				$ret[29] = '昭和の日';
			}
			break;
		case 5:
			// 憲法記念日
			$ret[3] = '憲法記念日';
			// みどりの日
			if ( $year > 2006 ) {
				$ret[4] = 'みどりの日';
			}
			// 子どもの日
			$ret[5] = '子供の日';
			break;
		case 7:
			// 海の日
			if ( $year > 2002 ) {
				$ret[$day+14] = '海の日';
			} else if ( $year > 1994 ) {
				$ret[21] = '海の日';
			}
			break;
		case 9:
			// 敬老の日
			if ( $year < 2003 ) {
				$ret[15] = '敬老の日';
			} else {
				$ret[$day+14] = '敬老の日';
			}
			// 秋分の日
			if ( $year > 1979 && $year < 2100 ) {
				$tmp = floor( 23.2488 + ( $year - 1980 ) * 0.242194 - floor( ( $year - 1980 ) / 4 ) );
				$ret[$tmp] = '秋分の日';
			}
			break;
		case 10;
			// 体育の日
			if ( $year < 2000 ) {
				$ret[10] = '体育の日';
			} else {
				$ret[$day+7] = '体育の日';
			}
			break;
		case 11:
			// 文化の日
			$ret[3] = '文化の日';
			// 勤労感謝の日
			$ret[23] = '勤労感謝の日';
			break;
		case 12:
			// 天皇誕生日
			if ( $year > 1988 ) {
				$ret[23] = '天皇誕生日';
			}
			break;
		}

		// 国民の休日をセット
		if ( $year > 1985 ) {
			for ( $i = 1; $i < date( 't', mktime( 0, 0, 0, $month, 1, $year ) ); $i++ ) {
				if ( isset( $ret[$i] ) && isset( $ret[$i+2] ) ) {
					$ret[$i+1] = '国民の休日';
					$i = $i + 3;
				}
			}
		}

		// 振り替え休日をセット
		$sday = $day - 1;
		if ( $sday == 0 ) {
			$sday = 7;
		}
		for ( $i = $sday; $i < date( 't', mktime( 0, 0, 0, $month, 1, $year ) ); $i = $i + 7 ) {
			// 2008/2/27 変更
			// if(isset($ret[$i])) {
			//	 $ret[$i+1] = '振替休日';
			// }
			$j = $i;
			while ( isset( $ret[$j] ) ) {
				$j++;
			}
			// 2008/3/20 修正
			if ( date( 'w', mktime( 0, 0, 0, $month, $j, $year ) ) > 0 ) {
				$ret[$j] = '振替休日';
			}
		}

		return $ret;
	}

}
