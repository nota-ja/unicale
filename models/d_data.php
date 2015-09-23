<?php
class CD_data extends CModel
{
/*
    var $tablename = "d_data.txt";
    var $datapath = "data";
    var $backuppath = "bak";
    var $table			= $datapath."/".$tablename;
    var $backup_table = = $backuppath."/".$tablename;
*/
    
    var $table			= "data/d_data.txt";

    
    var $validatefunc	= array(
							"startdate" => "notempty",
							"title" => "notempty"
							);
	var $validatemsg	= array(
							"startdate" => "Please input startdate.<br>",
							"title" => "Please input title.<br>"
							);
}
?>
