<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOptionRequest;
use App\Http\Requests\UpdateOptionRequest;
use App\Models\ChoiceMultiple;
use App\Models\Question;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(ChoiceMultiple::class);
        // $this->authorizeResource(Question::class);
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(AddOptionRequest $request)
    {
        
        session()->flash('message', 'Created successfully');
        session()->flash('error', 'success');
        ChoiceMultiple::create($request->validated());

        return to_route('questions.index', ['page' => request('page')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChoiceMultiple $option)
    {
        
        $choiceMultiple = ChoiceMultiple::find($option->id);
        return view('questions.edit-choice', compact('choiceMultiple'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOptionRequest $request, $id)
    {
        $choiceMultiple = ChoiceMultiple::find($id);
        $choiceMultiple->update($request->validated());
        return to_route('options.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChoiceMultiple $option)
    {
        
        $option->delete();
        return to_route('questions.index');
    }
}
