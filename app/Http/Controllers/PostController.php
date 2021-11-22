<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use App\Models\Avatar;
use App\Models\Comment;


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
        // return response([ "questions" =>$questions, "body" => $request->user()], 200);
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

    function removeLike(Request $request)
    {
        $removelike = DB::table('likes')->where(
            'post_id', '=', $request->postId, 'AND',
            'user_id', '=', $request->userId
        )->delete();

        $decrementlike = DB::table('questions')->where('id', $request->postId)->increment('likes', -1);

        return response(["message" => "Like deleted successfuly"], 204);
    }

    function addComment(Request $request)
    {
        $comment = new Comment;
        $comment->users_id = $request->user()->id;
        $comment->comment = $request->comment;
        $comment->question_id = $request->questionId;
        $comment->save();

        return response(["message" => "Comments successfully added to the database"], 201);
    }

    function getComments(Request $request)
    {
        $comments = DB::table('comments')->where(
            'question_id'. '=', $request->questionId
        )->select('comment', 'users_id')->paginate(10);

        return $comments;
    }

    /**
     * Avatar modification apis
     * @param usersId // int
     */

    function changeAvatar(Request $request)
    {
        $table_avatar = DB::table('avatar')->where('users_id', '=', $request->usersId)->select(
            'seed', 'mouth', 'eyebrows',
            'hair', 'eyes', 'nose',
            'ears', 'shirt', 'earrings',
            'glasses', 'facialHair', 'shirtColor',
            'mouthColor', 'hairColor', 'glassesColor',
            'facialHairColor', 'eyebrowColor', 'eyeShadowColor',
            'earringColor', 'baseColor'
        )->first();

        if($table_avatar == NULL){
            $avatar = new Avatar;
            $avatar->users_id = $request->usersId;
            $avatar->seed = $request->seed;
            $avatar->mouth = $request->mouth;
            $avatar->eyebrows = $request->eyebrows;
            $avatar->hair = $request->hair;
            $avatar->eyes = $request->eyes;
            $avatar->nose = $request->nose;
            $avatar->ears = $request->ears;
            $avatar->shirt = $request->shirt;
            $avatar->earrings = $request->earrings;
            $avatar->glasses = $request->glasses;
            $avatar->facialHair = $request->facialHair;
            $avatar->shirtColor = $request->shirtColor;
            $avatar->mouthColor = $request->mouthColor;
            $avatar->hairColor = $request->hairColor;
            $avatar->glassesColor = $request->glassesColor;
            $avatar->facialHairColor= $request->facialHairColor;
            $avatar->eyebrowColor= $request->eyebrowColor;
            $avatar->eyeShadowColor= $request->eyeShadowColor;
            $avatar->earringColor= $request->earringColor;
            $avatar->baseColor= $request->baseColor;
            $avatar->save();
            return response([
                "message" => "An avatar has beem created"
            ], 201);
        }else{
            $req_keys = $request->all();
            unset($req_keys["usersId"]);
            $table_update = DB::table('avatar')->where('users_id', $request->usersId)
            ->update($req_keys);

            if($table_update == 1){
                return response(["message" => "Your avatar has been updated successfuly"], 201);
            }else{
                return response(["message" => "Error in updating the avatar"], 400);
            }
        }
    }

    function getAvatar(Request $request){
        $avatar = Avatar::where('users_id', $request->user()->id)->select(
            'seed', 'mouth', 'eyebrows',
            'hair', 'eyes', 'nose',
            'ears', 'shirt', 'earrings',
            'glasses', 'facialHair', 'shirtColor',
            'mouthColor', 'hairColor', 'glassesColor',
            'facialHairColor', 'eyebrowColor', 'eyeShadowColor',
            'earringColor', 'baseColor'
        )->first();

        if($avatar != NULL){
            return $avatar;
        }
        else{
            return response(["seed" => $request->user()->username], 201);
        }

    }

}
