<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Question;

class PostController extends Controller
{
    function askQuestion(Request $request)
    {
        $question = new Question;
        $question->question = $request->question;
        $question->users_id = $request->users_id;
        $question->created_at = now();
        $question->updated_at = now();
        $question->save();

        $response = ["message" => "question successfuly posted to the database"];
        return response($response, 200);
    }

    function allQuestions(Request $request)
    {
        $subquery = DB::table('likes')->where('user_id' , '=', $request->user_id)->select('*');

        $questions = DB::table('questions')
            ->join('users', 'questions.users_id', '=', 'users.id')
            ->leftJoinSub($subquery, "L", function($join){
                global $request;
                $join->on('questions.id', '=', 'L.post_id');
            })
            ->select('questions.question', 'questions.likes', 'questions.comments', 'users.username', 'questions.created_at', 'questions.id as questions_id', 'L.id as likes_id')
            ->paginate(15);

        return response($questions, 200);
    }

    function addLike(Request $request)
    {
        $addlike = DB::table('likes')->insert([
            'post_id' => $request->postId,
            'user_id' => $request->userId,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $incrementlike = DB::table('questions')->where('id', $request->postId)->increment('likes');

        return response(["message" => "User has successfuly liked the post"], 201);
    }

    function removeLike(Request $request){
        error_log($request->userId);
        $removelike = DB::table('likes')->where(
            'post_id', '=', $request->postId, 'AND',
            'user_id', '=', $request->userId
        )->delete();

        $decrementlike = DB::table('questions')->where('id', $request->postId)->increment('likes', -1);

        return response(["message" => "Like deleted successfuly"], 204);
    }

}
