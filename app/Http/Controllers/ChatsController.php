<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Intervention\Image\Facades\Image;

use App\User;
use App\Message;
use App\Events\NewMessage;
use App\Events\UserTyping;

class ChatsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function home()
    {
    	return view('chats.chats-home');
    }

    public function get()
    {
        // get the users that authed follows and they follow back
        $contacts = array();

        foreach(auth()->user()->following as $f)
        {
            if($f->user->following->contains(auth()->user()->profile))
            {
                array_push($contacts, $f->user);
            }
        }

        $contacts = collect($contacts);

        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        $contacts = $contacts->map(function($contact) use ($unreadIds) {

            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            $contact->image = $contact->profile->image;

            return $contact;

        });

    	return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {	
        Message::where('from', $id)->where('to', auth()->id())->update(['read' => true]);

        $messages = Message::where(function($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })->get();

    	return response()->json($messages);
    }

    public function send(Request $request)
    {
        
        $type = null;

        if($request->has('image')){
            $allowedDocFileExtension = ['xlsx', 'xls', 'doc', 'docx', 'ppt', 'pptx', 'txt', 'pdf', 'zip'];
            $allowedImgFileExtension = ['jpeg','jpg','png','webp'];

            $file = $request->file('image');

            $file_name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $file_size = $file->getSize();

            if($file_size < 15000000)
            {
                if (in_array($extension, $allowedDocFileExtension))
                {
                    $file_name_in_storage = time() . '@' . $file_name;
                               
                    $path = $file->storeAs('/public/chats',$file_name_in_storage);

                    $type = 'file';

                }
                elseif (in_array($extension, $allowedImgFileExtension))
                {
                    $path = $request->image->store('chats', 'public');

                    $image = Image::make(public_path("storage/{$path}"))->fit(700,700);

                    $image->save();

                    $type = 'image';
                }
            }
        } 

        $message = Message::create([
            'from' => auth()->id(),
            'to' => $request->contact_id,
            'text' => $request->text,
            'file' => $path ?? null,
            'type' => $type
        ]);

        broadcast(new NewMessage($message));

        return response()->json($message);
    }

    public function file_download($file)
    {
        return response()->download(storage_path('app/public/chats/' . $file));
    }
}
