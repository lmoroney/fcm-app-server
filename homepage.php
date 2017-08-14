<!DOCTYPE html>
<html>
    <head>
        <title>FCM Test Page</title>
	<link rel="stylesheet" type="text/css" href="fcmsite.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript">
	function sendPushNotification(id){
		var rid;
		var msg;
		if(id=='all'){
		    rid = 'all';
		    msg = $('#allform textarea[name=message]').val();
		} else {
		    rid = $('#form' + id + ' input[name=regId]').val();
		    msg = $('#form' + id + ' textarea[name=message]').val();
		}
		$.ajax({
			url: "lm_send.php?message=" + msg + "&regid=" + rid
		});
		return false;
	}
        </script>
        
    </head>
    <body>
        <?php
        include_once 'db_functions.php';
        $db = new DB_Functions();
        $users = $db->getAllUsers();
        if ($users != false)
            $no_of_users = mysql_num_rows($users);
        else
            $no_of_users = 0;
        ?>
        <div class="container">
        	<h1>Send to all registered devices</h1>
            <form id="allform" name="" method="post" onsubmit="return sendPushNotification('all')">
                <div class="send_container">                                
                    <textarea rows="3" name="message" id="message" cols="25" class="txt_message" placeholder="Type message here"></textarea>
                    <input type="submit" class="send_btn" value="Send" onclick=""/>
                </div>
            </form>        	
            
            
            <h1>No of Devices Registered: <?php echo $no_of_users; ?></h1>
            <hr/>
            <ul class="devices">
                <?php
                if ($no_of_users > 0) {
                    ?>
                    <?php
                    while ($row = mysql_fetch_array($users)) {
                        ?>
                        <li>
                            <form id="form<?php echo $row["id"] ?>" name="" method="post" onsubmit="return sendPushNotification('<?php echo $row["id"] ?>')">
                                <label>ID: </label> <span><?php echo $row["fcm_regID"] ?></span>
                                <div class="clear"></div>
                                <div class="send_container">                                
                                    <textarea rows="3" name="message" id="message" cols="25" class="txt_message" placeholder="Type message here"></textarea>
                                    <input type="hidden" name="regId" id="regId" value="<?php echo $row["fcm_regID"] ?>"/>
                                    <input type="submit" class="send_btn" value="Send" onclick=""/>
                                </div>
                            </form>
                        </li>
                    <?php }
                } else { ?> 
                    <li>
                        No Users Registered Yet!
                    </li>
                <?php } ?>
            </ul>
        </div>
    </body>
</html>
