$(document).ready(function()
{
		$.post ( "friend_list.php" ,{ task: "get_friend_list" },
				
				function (response)
				{
					//$('#table').html(response);
					var friend_name = new Array();
					var friend_id = new Array();
					var friends = jQuery.parseJSON(response);
					var count = friends.length;
					for(var i in friends)
					{
						friend_name[i]=friends[i].full_name;
						friend_id[i]=friends[i].user_id_unique;
						var create_table = "<tr class='friend_chat123' id='"+ i +"'><td>"+ friend_name[i] +"<td>Profile</td></tr>";
						$('#chat_table').append(create_table);
					}

					$('.friend_chat123').on("click",function()
						{
							var arr = $(this).attr("id");
							$.post( "chat_message.php",
								{
									user_friend_name : friend_name[arr],
									user_friend_id : friend_id[arr]
								},
								function (response2)
								{

									//$('#table69').html(response2);
									$.post("chat.php",{ user_friend_name_2 :  friend_name[arr]},

												function (response3)
												{
													$('#table6968').html(response3);
												}

										);
								//$('#table698').load("chat.php");
								}

							);

						});
				}
		);
});



