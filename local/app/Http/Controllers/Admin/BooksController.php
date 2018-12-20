<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{
    function index(Request $request){
        $req = $request->get('search');

        $list_book = DB::table('books');

        if($req){
            $list_book = $list_book->where('code',$req);
        }

        $list_book = $list_book->orderByDesc('book_id')->paginate(15);

        foreach ($list_book as $book) {
            $book->homestay = DB::table('homestay')->where('homestay_id', $book->homestay_id)->first();
            $book->del_time = $this->get_time_h_m_s($book->time_del);
            $book->book_from = date('d/m/Y', strtotime(str_replace('/', '-', $book->book_from)));
            $book->book_to = date('d/m/Y', strtotime(str_replace('/', '-', $book->book_to)));
        }

        $data = [
            'list_book' => $list_book
        ];

        return view('admin.books.list',$data);
    }

    public function seeDetailModal(Request $request)
    {
        $id = $request->get('id');

        $book = DB::table('books')->where('book_id', $id)->first();

        if ($book) {
            $book->book_from = date('d/m/Y H:m', strtotime(str_replace('/', '-', $book->book_from)));
            $book->book_to = date('d/m/Y H:m', strtotime(str_replace('/', '-', $book->book_to)));
            $homestay = DB::table('homestay')->where('homestay_id', $book->homestay_id)->first();

            $book->user = DB::table('guest_users')->where('id', $book->book_user_id)->first();

            $bedroom = DB::table('bedrooms')->where('bedroom_id', $book->book_bedroom_id)->first();
        }

        $data = [
            'homestay' => $homestay,
            'bedroom' => $bedroom,
            'book' => $book
        ];
        return view('admin.books.see-detail-modal', $data);
    }

    function update_status($book_id,$status){
        if(DB::table('books')->where('book_id',$book_id)->update(['book_status' => $status,'time_del' => time()])){
            return back()->with('success','Cập nhật thành công');
        }else{
            return back()->with('error',"Cập nhật không thành công");
        }
    }
}
