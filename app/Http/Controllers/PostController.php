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
        $question->save();

        $response = ["message" => "question successfuly posted to the database"];
        return response($response, 200);
    }

    function allQuestions()
    {
        $questions = Question::paginate(
            $perPage=15, $columns = ['question', 'users_id', 'likes', 'comments']
        );
        return response($questions, 200);
    }

}
