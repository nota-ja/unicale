<?php
class CD_users extends CModel
{
	var $table			= "data/d_users.txt";
	var $validatefunc	= array(
							"username" => "notempty",
							"password" => "notempty"
							);
	var $validatemsg	= array(
							"username" => "Please input username.<br>",
							"password" => "Please input password.<br>"
							);
}
?>