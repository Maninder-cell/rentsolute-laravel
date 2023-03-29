<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function saveQuestion(QuestionRequest $request)
    {
        $question = new Question;

        $question->user_id = Auth::user()->id;
        $question->title = $request->title;
        $question->type = $request->type;
        $question->has_other = $request->has_other;

        $question->save();

        foreach ($request->options as $option) {
            $obj = array(
                'question_id' => $question->id,
                'text' => $option['text'],
                'preferred' => $option['preferred']
            );

            Option::create($obj);
        }

        $question_obj = Question::with('options')->find($question->id);

        return response()->json(['msg' => 'Question created successfully', 'data' => $question_obj]);
    }

    public function getQuestions(Request $request){
        $questions = Question::where('user_id',Auth::user()->id)->with('options')->get();

        return response()->json(['msg' => 'Questions found successfully','data' => $questions]);
    }
}
