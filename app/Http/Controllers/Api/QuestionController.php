<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaperIdRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Paper;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PaperIdRequest $request)
    {
        $questions =    Question::withCount('choiceMultiple')
            ->where('paper_id', $request->paper_id)
            ->when($request->question_id, function ($q) use ($request) {
                $q->where('id', $request->question_id);
            })
            ->get();

            $paper = Paper::find($request->paper_id);
        
        $collection =  QuestionResource::collection($questions);
        return $collection->additional(['paper_id' => $paper->id,'subject_id'=>$paper->subject_id]);
    }
}
