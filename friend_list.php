<?php 
require 'database_connect.php';
include 'page_name.php';

$method = $_SERVER['REQUEST_METHOD'];
if(strtolower($method)=='post')
{
	if(isset($_POST['task']) && $_POST['task']=="get_friend_list")
	{
		if( isset($_SESSION['user_id_unique']) && !empty($_SESSION['user_id_unique']) )
		{
			$user_PP = $_SESSION['user_id_unique'];
			$query_friends = "SELECT CONCAT(firstname,' ',surname) AS `full_name`, `user_id_unique` FROM `user_database` WHERE 
					`user_id_unique` IN 
						( SELECT `user_2` FROM `database1`.`".$user_PP."` WHERE message = ' ' )" ;
			if($query = mysql_query($query_friends))
			{
				$friends = array();
				$count=mysql_num_rows($query);
				while($query_array = mysql_fetch_assoc ($query))
				{
					$friends[] = $query_array;
				}
				echo json_encode($friends);
			}
			else die(mysql_error());
		}
	}
}


?>