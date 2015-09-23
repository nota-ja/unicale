<?php
class CD_holiday extends CModel
{
	var $table			= "data/d_holiday.txt";
	var $validatefunc	= array(
							"id" => "notempty",
							"holidaydate" => "notempty",
							"title" => "notempty"
							);
	var $validatemsg	= array(
							"id" => "Please input id.<br>",
							"holidaydate" => "Please input date.<br>",
							"title" => "Please input holiday title.<br>"
							);
}
?>