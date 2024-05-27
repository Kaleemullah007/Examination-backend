@extends('layouts.app')
@section('content')
    <a href="{{ route('subjects.index') }}"> Subjects</a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Submit Test') }}</div>
                    @if (session()->has('message'))
                        <div class="alert text-center alert-{{ session('success', 'error') }}">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('submit-test') }}">
                            @csrf
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ($questions as $question)
                                @if ($question->choiceMultiple->count() == 0)
                                    @php
                                        continue;
                                    @endphp
                                @endif
                                <div class="row mb-2">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">Q{{ $counter++ }}:
                                        {{ $question->question }}</label>

                                    <div class="col-md-8 row">


                                        @foreach ($question->choiceMultiple as $o)
                                            <div class="col-md-3">
                                                <input id="{{ $o->option }}" type="{{ $question->question_type }}"
                                                    class=" @error('name') is-invalid @enderror"
                                                    name="test[{{ $question->id }}]{{ $question->question_type == 'checkbox' ? '[]' : '' }}"
                                                    value="{{ old('name', $o->option) }}" autocomplete="name"><label
                                                    for="{{ $o->option }}">{{ $o->option }}</label>
                                            </div>
                                        @endforeach
                                        @error("test[{{ $question->id }}]")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                            @endforeach

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
