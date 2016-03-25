<?php
include 'page_name.php';
//include 'database_connect.php';



//$user_friend_name = 'Shubham Sharma';
//$user_friend_id = 'bad9bf1addc01ed5b14cb7333a5a94de';

class chat_box
{
	protected $db;
	protected $result;
	private $rows;

	public function __construct()
	{
		$this->db = new mysqli ('localhost','root','');
	}
	
	private function query_sql($sql)
	{
		$this->result = $this->db->query($sql);
	}
	private function rows_count()
	{
		for($x=1; $x <= $this->db->affected_rows ;$x++)
		{
			$this->rows[] = $this->result->fetch_assoc();
		}
		return $this->rows;
	}

	public function fetchMessages($table_name,$friend_name,$friend_id)
	{
		$this->query_sql(" SELECT 	`database1`.`".$table_name."`.`message`,
									`database1`.`".$table_name."`.`bool_user`

							FROM			`database1`.`".$table_name."`
							WHERE           `database1`.`".$table_name."`.`user_2` = '$friend_id'
							AND 			`database1`.`".$table_name."`.`message` != ' '
							ORDER BY 		`database1`.`".$table_name."`.`time_stamp` ASC

			");

		return $this->rows_count();
	}
	
	public function throwMessages($table_name , $friend_id , $message)
	{ 
		$this->query_sql(" INSERT INTO `database1`.`".$table_name."` (`ID`,`user_1`,`user_2`,`message`,`status_user`,`bool_user`,`time_stamp`)
			VALUES 
				( 
				'',
				'".$table_name."' ,
				'".$friend_id."' ,
				'".$this->db->real_escape_string(htmlentities($message))."' ,
				'' ,
				'0' ,
				now() 
				)
		");

		$this->query_sql(" INSERT INTO `database1`.`".$friend_id."` (`ID`,`user_1`,`user_2`,`message`,`status_user`,`bool_user`,`time_stamp`)
			VALUES 
				( 
				'',
				'".$friend_id."' ,
				'".$table_name."' ,
				'".$this->db->real_escape_string(htmlentities($message))."' ,
				'' ,
				'1' ,
				now() 
				)
		");
	}
}
/*
if( isset($_SESSION['user_id_unique']) && !empty($_SESSION['user_id_unique']) )
{
	$user_PP = $_SESSION['user_id_unique'];
	$chhat = new chat_box;

	$chhat->throwMessages($user_PP,$user_friend_id,"Enter it into database");
}*/

?>

