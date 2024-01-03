<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     *
     */
    public function store(Request $request){
        $request->validate([
            'comment' => 'required',
        ]);
        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->news_id = $request->news_id;
        $comment->comment = $request->comment;
        $comment->save();
        return redirect()->route('news.show', $request->slug)->with('success', 'Comment created successfully.');
    }

    public function destroy(Request $request){
        $comment = Comment::findOrFail($request->id);
        $comment->delete();
        return redirect()->route('news.show', $request->slug)->with('success', 'Comment deleted successfully.');
    }
}
