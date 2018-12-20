<?php
namespace App\Events;

//use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class NotiEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $data;
    public $book_user;

    public function __construct($message,$book_usser)
    {
        $this->data = array(
            'message'=> $message
        );
        $this->book_user = $book_usser;
    }

    public function broadcastOn()
    {
        return ['haivl-channel.'.$this->book_user];
    }
}