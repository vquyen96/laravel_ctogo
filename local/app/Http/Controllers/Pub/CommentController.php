<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function postAddComment(Request $request){
		$comment = new Comment;
		$comment->comment_rate = $request->comment_rate;
		$comment->comment_content = $request->comment_content;
		$comment->comment_homestay_id = $request->comment_homestay_id;
		$comment->comment_user_id = Auth::user()->id;
		$comment->save();
	}

	public function postEditComment($id, Request $request){
		$comment = Comment::find($id);
		$comment->comment_rate = $request->comment_rate;
		$comment->comment_content = $request->comment_content;
		$comment->save();
	}
}
