<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $comments = Comment::all();

      return view('comments', ['comments' => $comments]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $request->validate([
        'description' => 'required',
      ]);

      $comment = Comment::updateOrCreate(['id' => $request->id], [
                'blog_id' => $request->blog_id,
                // 'user_id' => $request->user_id,
                'user_id' => auth()->user()->id,
                'description' => $request->description
              ]);

      return response()->json(['code'=>200, 'message'=>'Comment Created successfully','data' => $comment,'blog_id'=>$request->blog_id], 200);

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      $comment = Comment::find($id);

      return response()->json($comment);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $comment = Comment::find($id)->delete();

    return response()->json(['success'=>'Comment Deleted successfully']);
  }
}