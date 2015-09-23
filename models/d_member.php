<?php
class CD_member extends CModel
{
	var $table			= "data/d_member.txt";
	var $validatefunc	= array(
							"id" => "notempty",
							"key" => "notempty",
							"memname1" => "notempty",
							"memname2" => "notempty",
							"memname3" => "notempty",
							"color" => "notempty"
							);
	var $validatemsg	= array(
							"id" => "Please input id.<br>",
							"key" => "Please input key.<br>",
							"memname1" => "Please input memname1.<br>",
							"memname2" => "Please input memname2.<br>",
							"memname3" => "Please input memname3.<br>",
							"color" => "Please input color.<br>"
							);
}
?>