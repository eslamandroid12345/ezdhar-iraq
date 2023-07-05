<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\OneRoomResource;
use App\Http\Resources\RoomsResources;
use App\Http\Resources\ChatResources;
use App\Models\Room;
use App\Models\RoomMessages;
use App\Traits\DefaultImage;
use App\Traits\NotificationTrait;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller{

    use NotificationTrait;

    public function myRooms(request $request){

        if (api()->user()->user_type == 'client')
            $data = Room::where('user_id',api()->user()->id);
        else
            $data = Room::where('adviser_or_freelancer_id',api()->user()->id);

        if($request->search_word != null && api()->user()->user_type == 'client'){

            $data = $data->whereHas('adviser_or_freelancer', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search_word . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search_word . '%');
            })->latest()->get();
            return helperJson(RoomsResources::collection($data));
        }

        if($request->search_word != null && api()->user()->user_type != 'client'){
            $data = $data->whereHas('user', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search_word . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search_word . '%');
            })->latest()->get();
            return helperJson(RoomsResources::collection($data));
        }

        $data = $data->latest()->get();

        return helperJson(RoomsResources::collection($data));
    }//end fun

    public function oneRoom(request $request){

        $rules = [
            'room_id'   => 'required|exists:rooms,id',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'room_id.exists' => 404,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'Failed,Room not found',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }
        $data = new RoomsResources(Room::find($request->room_id));
        return helperJson($data);
    }

    public function storeChatData(Request $request)
    {

        $rules = [

            'room_id'        => 'required|exists:rooms,id',
            'to_user_id'     => 'required|exists:users,id',
            'type'           => 'required|in:voice,text,file',
            'message'        => 'nullable',
            'file'           => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'room_id.exists' => 404,
            'to_user_id.exists' => 404,
            'type.required' => 402,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'Failed,one of Ids not found',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }


        if($request->message == null && $request->file == null)
            return helperJson(null,'يرجي ارسال رسالة او ملف',408);


//        if($request->type == 'file'){
//            $photoOrFile = $this->uploadFiles('chats', $request->file('file'));
//        }

        if ($image = $request->file('file')) {

            $destinationPath = 'chats/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $request['file'] = "$profileImage";
        }

        $message = RoomMessages::create([
            'from_user_id' => (int)api()->user()->id,
            'to_user_id' => (int)$request->to_user_id,
            'room_id' => (int)$request->room_id,
            'type' => $request->type,
            'message' => $request->message,
            'file' => $profileImage ?? NULL,
        ]);
        $room = new OneRoomResource(Room::find($request->room_id));

        $data = ['title'=>"تم وصل رسالة", 'body'=>($request->message) ?? "تم وصول ملف", 'data'=>new ChatResources($message),'note_type'=>"chat",'room'=>$room];
        $this->sendChatNotification($data,$request->to_user_id);

        return helperJson(new ChatResources($message),'تم ارسال الرسالة بنجاح');


    }//end fun


}//end class
