@extends('layouts.app')
@section('content')
    <a href="{{ route('papers.index') }}"> Paper</a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Paper') }}</div>
                    @if (session()->has('message'))
                        <div class="alert text-center alert-{{ session('error') }}">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('papers.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Paper Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <input id="description" type="text"
                                        class="form-control @error('description') is-invalid @enderror" name="description"
                                        value="{{ old('description') }}" autocomplete="description" autofocus>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="subject_id"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Select Subject') }}</label>

                                <div class="col-md-6">
                                    <select id="subject_id" type="text"
                                        class="form-control @error('subject_id') is-invalid @enderror" name="subject_id"
                                        value="{{ old('subject_id') }}" required autocomplete="subject_id" autofocus>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('subject_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="time"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Paper Time') }}</label>

                                <div class="col-md-6">
                                    <input id="paper_time" type="number"
                                        class="form-control @error('paper_time') is-invalid @enderror" name="paper_time"
                                        value="{{ old('paper_time') }}" required autocomplete="paper_time" autofocus>

                                    @error('paper_time')
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
