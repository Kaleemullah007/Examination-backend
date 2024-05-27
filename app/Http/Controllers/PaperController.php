<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Http\Requests\StorePaperRequest;
use App\Http\Requests\UpdatePaperRequest;
use App\Models\Subject;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->authorizeResource(Paper::class);
        $this->middleware(['auth']);
    }

    public function index()
    {
        $papers = Paper::withCount('question')->latest()->paginate($this->per_page);

        return view('papers.index', compact('papers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::activeSubject()->get();
        return view('papers.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaperRequest $request)
    {
        Paper::create($request->validated());
        session()->flash('message', 'Created successfully');
        session()->flash('error', 'success');
        return to_route('papers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Paper $paper)
    {
        return view('papers.show', compact('paper'));
    }


    /**
     * Display the specified resource.
     */
    public function subjectPapers(Subject $subject)
    {
        $papers = $subject->with(['papers', 'papers' => function ($query) {
            $query->withCount('question');
        }])
           
        ->where('id',$subject->id) ->paginate($this->per_page);
        return view('papers.subject-paper', compact('papers'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paper $paper)
    {
        $subjects = Subject::activeSubject()->get();
        return view('papers.edit', compact('paper', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaperRequest $request, Paper $paper)
    {
        $paper->update($request->validated());
        session()->flash('message', 'Updated successfully');
        session()->flash('error', 'success');
        return to_route('papers.edit', $paper->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paper $paper)
    {
        $paper->delete();
        session()->flash('message', 'Deleted successfully');
        session()->flash('error', 'success');
        return to_route('papers.index');
    }
}