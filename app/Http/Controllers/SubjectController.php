<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Subject::class);
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $subjects = Subject::withCount('papers')->latest()->paginate($this->per_page);

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        //
        Subject::create($request->validated());
        session()->flash('message', 'Created successfully');
        session()->flash('error', 'success');
        return to_route('subjects.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());
        session()->flash('message', 'Updated successfully');
        session()->flash('error', 'success');
        return to_route('subjects.edit', $subject->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        session()->flash('message', 'Deleted successfully');
        session()->flash('error', 'success');
        return to_route('subjects.index');
    }
}
