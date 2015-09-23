<?php
class CD_genre extends CModel
{
	var $table			= "data/d_genre.txt";
	var $validatefunc	= array(
							"id" => "notempty",
							"key" => "notempty",
							"genrename" => "notempty",
							"color" => "notempty"
							);
	var $validatemsg	= array(
							"id" => "Please input id.<br>",
							"key" => "Please input key.<br>",
							"genrename" => "Please input genrename.<br>",
							"color" => "Please input color.<br>"
							);
}
?>