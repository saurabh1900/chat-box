<?php 
include 'error_reporting.php';
$friend_name = $_POST['user_friend_name_2'];

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="Stylesheet/chat_table.css">
		<style type="text/css">


			.chat_box_container
			{
				height:350px;
				width:300px;
				background-color: #c2d6d6;
			}
			.chat_box_top_bar
			{
				height:7%;
				width:100%;
				background-color: #141f1f ;
				
			}
			.chat_box_top_name
			{
				display:inline-block;
				font-family: Arial, Helvetica, sans-serif;
				color:#c8d0c8;
				padding:5px;
				font-size: 14px;
			}
			.chat_message_container
			{
				font-family: Arial, Helvetica, sans-serif;
				padding:5px;
				height:85%;
				width:96%;
				overflow-y:auto;
				font-size:14px;
				border-left:1px solid gray;
				border-right:1px solid gray;
			}
			.friend_message
			{	
				margin-top: 5px;
				margin-right: 50px;
				padding-left: 10px;
				padding-right: 10px;
				padding-top:5px;
				padding-bottom: 5px;
				border-radius: 15px ;
				border:1px solid #669999;
				background-color: #425e5e ;
				color: #edf5f5 ;
				word-wrap: break-word;

			}
			.your_message
			{
				margin-top: 5px;
				margin-left: 50px ;
				padding-left: 10px;
				padding-top:5px;
				padding-bottom: 5px;
				padding-right: 10px;
				border-radius: 15px ;
				border:1px solid #669999;
				background-color: #75a3a3 ;
				color:black;
				word-wrap: break-word;
			}
			.chat_message_display_1
			{
				margin:5px;
			}
			.chat_message_type_confined
			{
				height:8%;
				width:99.3%;
				border:1px solid gray;
			}
			.chat_message_type
			{
				padding-left: 5px;
				padding-right: 5px;
				height:100%;
				width:100%;
				border:0px;
			}
		</style>
	</head>
	<body>
		<div class="chat_box_container">
			<div class="chat_box_top_bar">
				<div class="chat_box_top_name"><?php echo $friend_name; ?></div>
			</div>
			<div class="chat_message_container" id="scroll_t">
				<div class="chat_message_display_1">
					<div class ="friend_message"></div>
				</div>
				<div class="chat_message_display_1">	
					<div class ="your_message"></div>
				</div>
			</div>
			<div class="chat_message_type_confined">
				<input type="text" class="chat_message_type" placeholder="Type Your Message Here...">
			<div>
		</div> 

		<script type="text/javascript" src="javas/jquery_script.js"></script>
		<script type="text/javascript">
			$(document).ready(function()
			{

				
				var chat = {};
				chat.fetchMessages=function()
				{
					$.post("chat_message.php" , { method: 'fetch_message' },
					 
					 function(data)
					 {
					 	$('.chat_box_container .chat_message_container').html(data);
					 });
				}
				
				chat.throwMessages=function(message)
				{
					if($.trim(message).length!=0)
					{
						$.post("chat_message.php", { method : 'throw_message' , message :  message },

							function(data)
							{

								chat.fetchMessages();
								var myDiv = $("#scroll_t");
								myDiv.animate({ scrollTop: myDiv.prop("scrollHeight") });
								chat.entry.val('');
							});
					}
				}
				
				chat.interval = setInterval(chat.fetchMessages,2000);
				chat.fetchMessages();
				//$("#scroll_t").scrollTop($("#scroll_t")[0].scrollHeight);
								
				$("#scroll_t").animate({ scrollTop: $("#scroll_t")[0].scrollHeight },"fast");

				chat.entry = $('.chat_box_container .chat_message_type_confined .chat_message_type');
				chat.entry.bind('keydown',function(e)
				{
					//console.log(e.keyCode);
					if( e.keyCode === 13 && e.shiftKey === false)
					{
						chat.throwMessages( $(this).val() );
						e.preventDefault();
					}
				});

 				var elem = document.getElementById('data');
  				elem.scrollTop = elem.scrollHeight;

			});
			
		</script>
	</body>
</html>