<?php
class CD_holiday_static extends CModel
{
	var $table			= "data/d_holiday_static.txt";
	var $validatefunc	= array(
							"id" => "notempty",
							"mmdd" => "notempty",
							"title" => "notempty"
							);
	var $validatemsg	= array(
							"id" => "Please input id.<br>",
							"mmdd" => "Please input date.<br>",
							"title" => "Please input holiday title.<br>"
							);
}
?>