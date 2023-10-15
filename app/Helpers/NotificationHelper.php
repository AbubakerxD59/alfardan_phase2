<?php
namespace App\Helpers;

use App\Models\User;

class NotificationHelper{

public function pushnotification($title,$message,$id,$type, $notification_id=null){

	$users=User::where('id',$id)->first();
	
	//	dd($users['device_token']);
		if($users){
		$token = @$users['device_token'];  
	if(empty($token)){
	return null;
	}
		$from = "AAAAgjBltVg:APA91bHbrSsfif8DDY_BzM8l-tH-q2KxHQDMOuMyHVPzoKvr0KwejidwJFqbifUoYqUQctTILEFWDHzou1RfdNqGPE1C2PqxRBoZYXwxbwvOK-RfOoc_dt_jqFrF3ZgdgiB0EpttVtUO";
	$post_data = '{
            "to" : "' . $token . '",
            "data" : {
              "body" : "",
              "title" : "' . $title . '",
              "type" : "' . $type . '",
              "user_id" : "' . $id . '",
              "message" : "' . $message . '",
			  "notification_id":"'.$notification_id.'",
            },
			"android": {
			  "priority":"high"
			},
            "notification" : {
                 "body" : "' . $message . '",
                 "title" : "' . $title . '",
                  "type" : "' . $type . '",
                 "user_id" : "' . $id . '",
                 "message" : "' . $message . '",
                "icon" : "new",
                "sound" : "default"
                },
 
          }';
	 
		//$msg = array
		//(
		//	'body'  => $message,
		//	'title' => $titile,
		//);

	//	$fields = array
	//	(
	//		'to'        => $token,
	//		'notification'  => $msg
	//	);

		$headers = array
		(
			'Authorization: key=' . $from,
			'Content-Type: application/json'
		);
	        //#Send Reponse To FireBase Server 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		//curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, $post_data );
		$result = curl_exec($ch );
		//dd($result);
		curl_close( $ch );
	
}

}


}