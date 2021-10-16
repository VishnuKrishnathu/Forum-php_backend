<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Question;

class PostController extends Controller
{
    function askQuestion(Request $request){
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
        $questions = DB::table('questions')
        ->join('users', 'questions.users_id', '=', 'users.id')
        ->leftJoin('likes', function($join){
            global $request;
            $join->on('questions.id', '=', 'likes.post_id')
            ->where('likes.user_id', '=', $request->user_id);
        })
        ->select('questions.question', 'questions.likes', 'questions.comments', 'users.username', 'questions.created_at', 'questions.id as questions_id', 'likes.id as likes_id')
        ->paginate(15);

        return response($questions, 200);
    }

}
