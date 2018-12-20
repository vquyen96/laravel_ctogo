<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    function index(Request $request){
        $req = $request->all();

        $query = Comment::with('user')->with('homestay');

        if(isset($req['search'])){
            $query = $query->where('comment_content','like',"%".$req['search'].'%');
        }

        $list_comment = $query->orderByDesc('comment_id')->paginate(15);

        $data = [
            'list_comment' => $list_comment
        ];

        return view('admin.comments.list',$data);
    }

    function update_status($id){
        $comment = Comment::find($id);
        $comment->status == 2 ? $comment->status = 1 : $comment->status = 2;
        $comment->save();

        return json_encode([
            'comment' => $comment->toJson()
        ]);
    }

    function update_home($id){
        $comment = Comment::find($id);
        $comment->home == 2 ? $comment->home = 1 : $comment->home = 2;
        $comment->save();

        return json_encode([
            'comment' => $comment->toJson()
        ]);
    }

    function delete_comment($id){
        if(Comment::find($id)->delete()){
            return redirect()->route('list_comment')->with('success','Xóa thành công');
        }else {
            return redirect()->route('list_comment')->with('error','Xóa không thành công');
        }
    }

    function sort_comment(Request $request){
        if($request->get('comment')){

        }

        $list_comment = Comment::with('user')->with('homestay')->where('home',Comment::ACTIVE)->orderBy('sort')->paginate(30);

        $data = [
            'list_comment' => $list_comment
        ];

        return view('admin.comments.sort_comment',$data);
    }

    function delete_comment_hot($id){
        if(DB::table('comments')->where('comment_id',$id)->update(['home' => Comment::NON_ACTIVE])){
            return redirect()->route('sort_comment')->with('success','Xóa thành công');
        }else {
            return redirect()->route('sort_comment')->with('error','Xóa không thành công');
        }
    }

    function update_sort_comment(Request $request){
        $req = $request->get('comment');
        foreach ($req as $key=>$value){
            DB::table('comments')->where('comment_id',$key)->update(['sort'=>$value]);
        }
        return back()->with('success',"Sắp xếp thành công");
    }
}
