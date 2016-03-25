<?php
include 'error_reporting.php';
require 'page_name.php';
require 'chat-box.php';
 


//echo "hey";

if(!isset($_SESSION)) {	session_start(); }
if(isset($_POST['user_friend_id']))
{
	$user_friend_id = $_POST['user_friend_id'];
	$_SESSION['user_id'] = $user_friend_id;
}

if(!isset($_SESSION)) {	session_start(); } 
if (isset($_POST['user_friend_name']))
{
	$user_friend = $_POST['user_friend_name'];
	$_SESSION['user_friend'] = $user_friend;
}

session_write_close();


session_write_close();

$user_friend_name = $_SESSION['user_friend']; 
$user_friend_id = $_SESSION['user_id'];


$method_post = $_SERVER['REQUEST_METHOD'];
if(strtolower($method_post)=='post')
{
	if( isset($_SESSION['user_id_unique']) && !empty($_SESSION['user_id_unique']) )
	{
		$user_PP = $_SESSION['user_id_unique'];
		if ( isset($_POST['method'])===true && !empty(isset($_POST['method'])) )
		{
			$chat = new chat_box;
			$method = trim($_POST['method']);
			if($method === 'fetch_message')
			{
				$old_messages = $chat->fetchMessages($user_PP,$user_friend_name,$user_friend_id);

				if(empty($old_messages)===true)
				{
					echo 'No old messages';
				}	
				else
				{
					foreach ($old_messages as $message) {

						if($message['bool_user'] == '1')
						{

							?>

							<div class="friend_message">
								<?php echo nl2br($message['message']);?>
							</div>

							<?php
						}
						else
						{
							?>

							<div class="your_message">
								<?php echo nl2br($message['message']);?>
							</div>

							<?php
						}






					}
				}
			}
			else if($method === 'throw_message')
			{
				if(isset($_POST['message']) && !empty($_POST['message']))
				{
					$message = trim($_POST['message']);
					if(!empty( $message ))
					{
						$chat->throwMessages($user_PP , $user_friend_id , $message);
					}
				}
			}
		}
	}
}

?>