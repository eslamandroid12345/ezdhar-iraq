<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\PhoneTokens;
use App\Models\User;
use App\Models\Notification as NotificationModel;

Trait  FirebaseNotification
{
//    private $serverKey = 'AAAAzRLrkcM:APA91bGwA756jCNkyOkyuS7cInuV4S2A_lu3ncT-6d8w4-Xd2WZUTfY_3Tk7UIYbyBLaN278R90Zo9EUaFYtmDNFcaaZWUH93GxtireMp-gknLXpDTEirsAsr0SOtyt_hnBF0T9msgB1';
    private $serverKey = 'AAAAklzt2qY:APA91bEAkCW-KSLRE4ne2hfGXPDDk2qQjAny89pS0t_pK1itouJwns3Y_mifVOfqKidRn8V5-YPfdkXIl6RKxxJ16Qny24vrPulfVDuxPF7g2sjpcBYo4u31TvcntKQt3hu8fmSuH6kC';

    public function sendBasicNotification($usersIds,$data)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';


        foreach($usersIds as $userId)
        {
            $storedData = [];
            $storedData['title'] = $data['title'];
            $storedData['text'] = $data['body'];
            $storedData['ad_id'] = $data['ad_id'];
            $storedData['user_id'] = $userId;
            Notification::create($storedData);
        }

        $query['user_id'] = $usersIds;
        $tokens = PhoneTokens::wherein('user_id',$usersIds)->pluck('token')->toArray();

        $fields = array(
            'registration_ids' => $tokens,
            'data' => $data,
            'notification' =>$data,
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

    public function sendChatNotification($data,$user_id)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $query['user_id'] = $user_id;

//        return $query;
        $tokens = array_values(PhoneTokens::where($query)->pluck('token')->toArray());
         $data['notification_type'] = 'chat';
        $fields = array(
            'registration_ids' => $tokens,
            'data' => $data,
//            'notification' =>$data,
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
