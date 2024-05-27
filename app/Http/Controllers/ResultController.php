<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Http\Requests\StoreResultRequest;
use App\Http\Requests\UpdateResultRequest;
use App\Models\Examination;
use App\Notifications\ResultStatusNotification;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Result::class);
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = Result::with(['paper', 'subject','user'])->latest()->paginate($this->per_page);
        return view('results.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Result $result)
    {
        $result->load(['user_answer','user_answer.question:id,question,question_type,correct_answer','user_answer.question.choiceMultiple:id,option,question_id']);
        
        return view('results.view',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Result $result)
    {
        $result->load(['user_answer','user_answer.question:id,question,question_type,correct_answer','user_answer.question.choiceMultiple:id,option,question_id']);
        
        return view('results.edit',compact('result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResultRequest $request, Result $result)
    {
        
        $questions = $request->is_correct; 
        $dbquestions = Examination::whereIn('id',array_keys($questions))->get();
        $correct_answer = 0;
        $wrong_answer = 0;
        
        foreach($dbquestions as $question){

            if(isset($questions[$question->id])){
                $question->is_auto = false;
                if($questions[$question->id] == "true"){
                    $question->is_correct = true;
                    $question->save();
                    $correct_answer++;
                    
                }else{
                    $question->is_correct = false;
                    $wrong_answer++;
                }
                $question->save();
                

            }
            
        }

        $result->correct_answer  = $correct_answer;
        $result->wrong_answer  = $wrong_answer;
        $result->status  = $request->status;
        $result->save();

        $user = $result->user;
        
        $message = 'Your result is review by Admin, Now you have correct answers are '.$correct_answer. ' and Wrong anwer '.$wrong_answer ;
       $user->notify(new ResultStatusNotification($message));
        session()->flash('message','Result has been updated');
        session()->flash('error','success');
        return to_route('results.edit',$result->id);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        //
    }
}
