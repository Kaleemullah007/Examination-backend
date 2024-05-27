@extends('layouts.app')
@section('content')
    <a href="{{ route('questions.index') }}"> Questions</a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Question') }}</div>
                    @if (session()->has('message'))
                        <div class="alert text-center alert-{{ session('error') }}">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('questions.update', $question->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="question"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Question') }}</label>

                                <div class="col-md-6">
                                    <input id="question1" type="text"
                                        class="form-control @error('question1') is-invalid @enderror" name="question1"
                                        value="{{ old('question1', $question->question) }}" required autocomplete="question"
                                        autofocus>

                                    @error('question1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="question"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Correct Answer') }}</label>

                                <div class="col-md-6">
                                    <input id="correct_answer" type="text"
                                        class="form-control @error('correct_answer') is-invalid @enderror"
                                        name="correct_answer" value="{{ old('correct_answer', $question->correct_answer) }}"
                                        required autocomplete="correct_answer" autofocus>

                                    @error('correct_answer')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="question_type"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Question Type') }}</label>

                                <div class="col-md-6">
                                    <select id="question_type" type="text"
                                        class="form-control @error('question_type') is-invalid @enderror"
                                        name="question_type">
                                        <option value="radio" @selected($question->question_type == 'radio')>Radio</option>
                                        <option value="checkbox" @selected($question->question_type == 'checkbox')>checkbox</option>
                                        <option value="Textarea" @selected($question->question_type == 'Textarea')>Textarea</option>
                                    </select>

                                    @error('question_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="paper_id"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Select Paper') }}</label>

                                <div class="col-md-6">
                                    <select id="paper_id" type="text"
                                        class="form-control @error('paper_id') is-invalid @enderror" name="paper_id">
                                        @foreach ($papers as $paper)
                                            <option value="{{ $paper->id }}">{{ $paper->name }}</option>
                                        @endforeach

                                    </select>

                                    @error('paper_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <input type="hidden" name="paper_id" value="{{ old('paper_id', request('paper_id')) }}"> --}}

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
