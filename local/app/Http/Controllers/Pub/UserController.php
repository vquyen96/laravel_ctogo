<?php

namespace App\Http\Controllers\Pub;

use App\Models\BedRoom;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\HomeStay;
use App\Http\Requests\CreateUserRequest;
use Auth;
use File;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    //Signup
    public function getSignup()
    {
        return view('public.signup');
    }

    public function postSignup(CreateUserRequest $request)
    {
        $user = DB::table('guest_users')->where($request->email)->first();

        if($user){
            back()->with('error','Email đã tồn tại trên hệ thống');
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if ($user->save()) {
            return redirect()->route('getProfile');
        } else {
            return back();
        }
    }

    //
    public function getProfile()
    {
        $user = Auth::user();

        $list_book = DB::table('books')->where('book_user_id', $user->id)->orderByDesc('book_id')->paginate(15);

        foreach ($list_book as $book) {
            $book->homestay = DB::table('homestay')->where('homestay_id', $book->homestay_id)->first();
            $book->del_time = $this->get_time_h_m_s($book->time_del);
            $book->book_from = date('d/m/Y', strtotime(str_replace('/', '-', $book->book_from)));
            $book->book_to = date('d/m/Y', strtotime(str_replace('/', '-', $book->book_to)));
        }

        $list_notification = DB::table('notification')->where('user_rev', $user->id)->orderByDesc('id')->paginate(15);

//	    foreach ($list_notification as $noti){
//	        $noti->user_action_data = User::find($noti->user_action);
//	        $noti->user_rev_data = User::find($noti->user_rev);
//        }

        $data = [
            'list_book' => $list_book,
            'list_notification' => $list_notification
        ];

        return view('public.guest.profile', $data);
    }

    public function seeDetailModal(Request $request)
    {

        $id = $request->get('id');

        $book = DB::table('books')->where('book_id', $id)->first();

        if ($book) {
            $book->book_from = date('d/m/Y H:m', strtotime(str_replace('/', '-', $book->book_from)));
            $book->book_to = date('d/m/Y H:m', strtotime(str_replace('/', '-', $book->book_to)));
            $homestay = DB::table('homestay')->where('homestay_id', $book->homestay_id)->first();
            if ($homestay) {
                $homestay->user = DB::table('users')->where('id', $homestay->homestay_user_id)->first();
            }
            $bedroom = DB::table('bedrooms')->where('bedroom_id', $book->book_bedroom_id)->first();
        }

        $data = [
            'homestay' => $homestay,
            'bedroom' => $bedroom,
            'book' => $book
        ];
        return view('public.guest.see-detail-modal', $data);
    }

    function update_status_book($id, $status)
    {
        if($status == 3){
            return back()->with('error', 'Bạn không có quyền thực hiện chức năng này');
        }
        $book = DB::table('books')->where('book_id', $id)->update(['book_status' => $status,'time_del' => time()]);

        if ($book) {
            switch ($status) {
                case 2:
                    return back()->with('warning', 'Hết thời gian thanh toán');
                    break;
//                case 3:
//                    return back()->with('success', 'Thanh toán thành công');
//                    break;
                case 4:
                    return back()->with('success', 'Hủy thanh toán thành công');
                    break;
            }
        }
    }

    public function getBook()
    {
        return view('public.guest.book');
    }

    public function getNotification()
    {
        return view('public.guest.notification');
    }

    public function postUpdateProfile(CreateUserRequest $request)
    {
        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->sex = $request->sex;
        $user->description = $request->description;
        $user->save();
        return back();
    }

    public function postAjaxAvatar(CreateUserRequest $request)
    {
        $user = User::find(Auth::id());
        if ($request->image != null) {
            if (File::exists('local/storage/app/image/user-3/' . $user->avatar)) {
                File::delete('local/storage/app/image/user-3/' . $user->avatar);
            }
            if (File::exists('local/storage/app/image/user-3/resized-' . $user->avatar)) {
                File::delete('local/storage/app/image/user-3/resized-' . $user->avatar);
            }
            $user->avatar = saveSingleImage($request->image, 200, 'image/user-3');
        }
        $user->save();
        return $user;
    }

    public function upload_image_payment(Request $request)
    {
        $image = $request->file('image_payment');
        if ($request->hasFile('image_payment')) {
            $image_path = saveSingleImage($image, 200, 'image/image-payment');
        }

        if($image_path){
            DB::table('books')->where('book_id',$request->book_id)->update(['image_payment' => $image_path]);
            return json_encode([
                'status' => 1
            ]);
        }else {
            return json_encode([
                'status' => 0
            ]);
        }
    }

    public function postUpdatePassword(CreateUserRequest $request)
    {
        $user = Auth::user();
        if (!(Hash::check($request->old_password, $user->password))) {
            return redirect()->back()->with("error", "Mật khẩu cũ không chính xác");
        }

        if (strcmp($request->old_password, $request->new_password) == 0) {
            return redirect()->back()->with("error", "Mật khẩu mới không được trùng với mật khẩu cũ");
        }

        if (!strcmp($request->confirm_password, $request->new_password) == 0) {
            return redirect()->back()->with('error', 'Mật khẩu mới không khớp nhau');
        }

        $user->password = bcrypt($request->new_password);
        $user->save();
        return back()->with('success', 'Mật khẩu thay đổi thành công!');
    }
}