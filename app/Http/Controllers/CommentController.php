<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $Comments = Comment::orderBy('id')->get();

        // return response()->json([
        //     'status' => 'success',
        //     'Comments' => $Comments
        // ]);

        $comments = Comment::all();

        return new CommentCollection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Comment Created successfully!",
            'Comment' => $comment
        ], 201);

        // $comment = Comment::create($request->all());

        // return response()->json([
        //     'status' => true,
        //     'message' => "Article Created successfully!",
        //     'article' => $comment
        // ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $Comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $Comment)
    {
        $Comment->find($Comment->id);
        if (!$Comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        return response()->json($Comment, 200);


        // Product Detail
        // $comment = Comment::find($comment);
        // if(!$comment){
        // return response()->json([
        //     'message'=>'Product Not Found.'
        // ],404);
        // }

        // // Return Json Response
        // return response()->json([
        //     'product' => $comment
        // ],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $Comment
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCommentRequest $request, Comment $Comment)
    {
        $Comment->update($request->all());

        if (!$Comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => "Comment Updated successfully!",
            'Comment' => $Comment
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $Comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $Comment)
    {
        $Comment->delete();

        if (!$Comment) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfully'
        ], 200);
    }
}
