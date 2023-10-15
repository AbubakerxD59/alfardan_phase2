<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use Carbon\Carbon;

class ChatController extends BaseController
{
    public function index(Request $request)
    {
        $user_id = auth()->id();
        $type = $request->type;

        $chat = Chat::where(['user2_id' => $user_id, 'type' => $type])->first();

        if (!$chat) {

            Chat::create([
                'user1_id' => $request->user1_id,
                'user2_id' => $user_id,
                'type' => $type
            ]);
        }

        $data = [
            'chat' => Chat::with('messages.images')
            ->where(['user2_id' => $user_id, 'type' => $type])
            ->first()
        ];

        return $this->successResponse($data);
    }

    public function sendMessage(Request $request)
    {
		
		
       $message = Message::create($request->all() + ['sender_id' => auth()->id()]);
		
        if ($request->image_ids) {
            $message->addImages($request->image_ids);
        }
		
		$data=$request->all();
        $lastmessage=Message::where('chat_id',$data['chat_id'])->where('id','<>',$message->id)->orderby('id','desc');
        $totalmsg=clone $lastmessage;
        $lastmessage=$lastmessage->first();
		if($lastmessage){
			$from= Carbon::createFromFormat('Y-m-d H:s:i', $lastmessage->updated_at);
			$to = Carbon::createFromFormat('Y-m-d H:s:i',date('Y-m-d H:s:i'));
		}else{		
			$from= Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:s:i'));
			$to = Carbon::createFromFormat('Y-m-d H:s:i',date('Y-m-d H:s:i'));
		}
		
		if($totalmsg->count()==0 || $to->diffInHours($from)>23){
			$data['text']="Thank you for contacting us. Our team will reply to you shortly.";
			$data['receiver_id']= auth()->id();
			$data['sender_id']= 1;
			Message::create($data);
		}
        return $this->successResponse([], 'Message has been sent successfully');
    }
}
