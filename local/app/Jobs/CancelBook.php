<?php

namespace App\Jobs;

use App\Models\Book;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CancelBook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $book;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($book)
    {
        $this->book = $book;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->book->status == 1){
            DB::table('books')->where('book_id',$this->book->book_id)->update(['book_status' => 2]);

            $book = DB::table('books')->where('book_id'.$this->book->book_id)->first();

            $data = [
                'user_id_action' => 1,
                'user_id_rev' => $book->book_user_id,
                'action' => 2,
                'message' => 'bạn đẫ hết thời gian thanh toán cho phiên đặt chỗ'
            ];

            $noti = new Notification();
            $noti->save($data);
        }
    }
}
