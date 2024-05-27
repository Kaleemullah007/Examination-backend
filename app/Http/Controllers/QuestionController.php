<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Paper;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Question::class);
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with('choiceMultiple')->latest()->paginate($this->per_page);
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $papers = Paper::get();
        return view('questions.create', compact('papers'));
    }

    public function addOption()
    {

        // dd('dd');
        return view('questions.choice');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $data = $request->validated();
        if($request->question_type == 'checkbox'){
            $correct_answer = explode(',',$request->correct_answer);
           sort($correct_answer);
           $correct_answer = implode(',',$correct_answer);
           $data['correct_answer'] = $correct_answer;
        }

        Question::create($data);
        session()->flash('message', 'Created successfully');
        session()->flash('error', 'success');
        return to_route('questions.index');
    }

    /**
     * Display the specified resource.
     */
    public function subjectPaperQuestions(Paper $paper)
    {

        // $papers = $paper->with(['question', 'question.choiceMultiple'])
        //     ->paginate($this->per_page);
        $questions  = Question::with('choiceMultiple')->where('paper_id', $paper->id)->paginate($this->per_page);

        return view('questions.index', compact('questions'));
    }

    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {

        $papers = Paper::get();
        return view('questions.edit', compact('question', 'papers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $data = $request->validated();
        $data['question'] =  $data['question1'];
        unset($data['question1']);


        
        if($request->question_type == 'checkbox'){
            $correct_answer = explode(',',$request->correct_answer);
           sort($correct_answer);
           $correct_answer = implode(',',$correct_answer);
           $data['correct_answer'] = $correct_answer;
        }

        $question->update($data);
        // $question->choiceMultiple()->update($choice_data);
        session()->flash('message', 'Updated successfully');
        session()->flash('error', 'success');
        return to_route('questions.edit', $question->id);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        session()->flash('message', 'Deleted successfully');
        session()->flash('error', 'success');
        return to_route('questions');
    }
}
