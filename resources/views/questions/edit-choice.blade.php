@extends('layouts.app')
@section('content')
    <a href="{{ route('questions.index') }}"> Questions</a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Option') }}</div>
                    @if (session()->has('message'))
                        <div class="alert text-center alert-{{ session('error') }}">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('options.update', $choiceMultiple->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="option"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Option') }}</label>

                                <div class="col-md-6">
                                    <input id="option" type="text"
                                        class="form-control @error('option') is-invalid @enderror" name="option"
                                        value="{{ old('option', $choiceMultiple->option) }}" required autocomplete="option"
                                        autofocus>

                                    @error('option')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
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
