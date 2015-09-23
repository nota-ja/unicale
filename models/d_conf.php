<?php
class CD_conf extends CModel
{
	var $table			= "data/d_conf.txt";
	var $validatefunc	= array(
							"confkey" => "notempty",
							"confvalue" => "notempty"
							);
	var $validatemsg	= array(
							"confkey" => "Please input key.<br>",
							"confvalue" => "Please input value.<br>"
							);
}
?>