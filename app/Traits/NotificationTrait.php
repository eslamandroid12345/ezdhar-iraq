<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\Order;
use App\Models\PhoneTokens;
use App\Models\Room;
use App\Models\RoomMessages;
use App\Models\User;
use App\Models\Notification as NotificationModel;

Trait  NotificationTrait{

//    private $serverKey = 'AAAAklzt2qY:APA91bEAkCW-KSLRE4ne2hfGXPDDk2qQjAny89pS0t_pK1itouJwns3Y_mifVOfqKidRn8V5-YPfdkXIl6RKxxJ16Qny24vrPulfVDuxPF7g2sjpcBYo4u31TvcntKQt3hu8fmSuH6kC';
    private $serverKey = 'AAAAklzt2qY:APA91bEAkCW-KSLRE4ne2hfGXPDDk2qQjAny89pS0t_pK1itouJwns3Y_mifVOfqKidRn8V5-YPfdkXIl6RKxxJ16Qny24vrPulfVDuxPF7g2sjpcBYo4u31TvcntKQt3hu8fmSuH6kC';

    public function sendBasicNotification($title,$message,$user_id,$room_id = null,$note_type=null)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $storeData = [

            'title'   => $title,
            'message' => $message,
            'user_id' => $user_id,

        ];

        Notification::create($storeData);//end of notification


        $data = [

            'title'   => $title,
            'body'    => $message,
            'note_type' => $note_type,
            'room_id' => $room_id,
            'room'    => Room::find($room_id),
        ];

        $tokens = PhoneTokens::where('user_id',$user_id)->pluck('token')->toArray();


//        return Token::where('provider_id',$provider_id)->pluck('token')->toArray();
        $fields = array(
            'registration_ids' => $tokens,
            'data'             => $data,
        );

        $headers = array(
            'Authorization: key=' . $this->serverKey,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
    }

    public function sendChatNotification($data, $user_id=null)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';


        $tokens = PhoneTokens::where('user_id',$user_id)->pluck('token')->toArray();

        $fields = array(

            'registration_ids' => $tokens,
            'data' => $data,
        );

        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . $this->serverKey,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
    }

}//end trait
