<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserIdRequest;
use App\Http\Requests\StoreResultRequest;
use App\Http\Resources\ResultResource;
use App\Jobs\Autocheck;
use App\Models\Examination;
use App\Models\Paper;
use App\Models\Question;
use App\Models\Result;
use App\Models\User;
use App\Notifications\TestNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(UserIdRequest $request)
    {


        $result = Result::with(['paper', 'subject'])->whereUserId($request->user_id)->get();

        return ResultResource::collection($result);
    }

    public function submitTest(StoreResultRequest $request)
    {
        $questions = Question::where('paper_id', 1)->get()->pluck(null, 'id');

        $user = $request->user();

        $test = $this->questionStructure($request->test);
        $reqdata = $request->all();
        // dd($test);


        // check questions correct and wrong then we will send notification to user admin.
        // maping with  paper questions and submitted question answer then we finalize
        dispatch(new Autocheck($test, $reqdata, $user))->delay(Carbon::now()->addSeconds(5));



        return response(['message' => 'Test submitted successfully.']);
    }

    function questionStructure($test){
        $user_questions =  array_filter($test);
        $arrangeing_questions = [];
        foreach($user_questions as $question){

            $parts= explode('__',$question);
            
            if($parts[2] == 'radio')
            $arrangeing_questions[$parts[0]] = $parts[3];
        elseif($parts[2] == 'checkbox'){
            $arrangeing_questions[$parts[0]][] = $parts[3];
            sort($arrangeing_questions[$parts[0]]);
        }
        
    



        }

        return $arrangeing_questions;
    }
    function create()
    {
        $questions = Question::with(['choiceMultiple'])->where('paper_id', 1)->get();

        return view('test', compact('questions'));
    }

    function checkQuestion($submittedTest)
    {

        $questions = Question::where('paper_id', 1)->get()->pluck(null, 'id');


        $paper_id = 1;
        $subject_id = 1;
        $correct = 0;
        $wrong = 0;
        $user_id = 2;
        $data = array();
        foreach ($questions as $key => $question) {
            $user_selected = '';
            if (isset($submittedTest[$key])) {
                $user_selected = is_array($submittedTest[$key]) ?
                    !empty($submittedTest[$key]) ? implode('__', $submittedTest[$key]) :
                    $submittedTest[$key] : $submittedTest[$key];
            }
            $flag = false;
            if (isset($submittedTest[$key])) {
                if ($question->correct_answer == $submittedTest[$key]  && $question->question_type == 'radio') {
                    ++$correct;
                    $flag = true;
                } elseif (strtolower(implode(',', explode(',', $question->correct_answer))) == strtolower(implode(',', is_array($submittedTest[$key]) ? $submittedTest[$key] : [$submittedTest[$key]])) && $question->question_type == 'checkbox') {
                    ++$correct;
                } else {
                    ++$wrong;
                }
            } else {
                ++$wrong;
            }



            $data['exam'][] = [
                'user_answer' => $user_selected,
                'paper_id' => $paper_id,
                'subject_id' => $subject_id,
                'user_id' => $user_id,
                'question_id' => $key,
                'is_correct' => $flag,
                'is_auto' => true,

            ];
        }
        $data['correct'] = $correct;
        $data['wrong'] = $wrong;

        return $data;
    }

}
