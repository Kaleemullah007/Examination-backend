@extends('layouts.app')
@section('content')
<a href="{{ route('results.index') }}"> Results</a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit result') }} Correct:{{ $result->correct_answer }},   Wrong:{{ $result->wrong_answer }} Result Status : <span class="badge badge-primary bg-primary"> {{ucfirst($result->status)}} </span></div>
                    @if (session()->has('message'))
                        <div class="alert text-center alert-{{ session('error') }}">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('results.update', $result->id) }}">
                            @csrf
                            @method('PUT')


                            <div class="row mb-3">
                                <label for="status"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

                                <div class="col-md-6">
                                    <select id="status" type="text"
                                        class="form-control @error('status') is-invalid @enderror" name="status"
                                        required autocomplete="status" autofocus>
                                        <option value="pending"  @selected($result->status =='pending')>Pending</option>
                                        <option value="review" @selected($result->status =='review')>Review</option>
                                        <option value="approved" @selected($result->status =='approved')>Approved</option>
                                    </select>

                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @foreach($result->user_answer as $q)
                            
                       
                            <div class="row mb-3">
                                <label for="question"
                                    class="col-md-6 col-form-label text-md-end">{{ $q->question->question }}
                                </label>

                                <div class="col-md-6 ">
                                    <label class="col-md-3 col-form-label text-md-end">
                                     <input   name="is_correct[{{$q->id}}]" id="uq_{{$q->id}}" type="radio" value="true" @checked($q->is_correct==1)> <label for="uq_{{$q->id}}">Correct</label> 
                                    </label>
                                    <label class="col-md-3 col-form-label text-md-end">
                                    <input   name="is_correct[{{$q->id}}]" id="wuq_{{$q->id}}" type="radio" value="false" @checked($q->is_correct==0)  class="ml-2"> <label for="wuq_{{$q->id}}"> Wrong</label>
                                    </label>
                                </div>
                                <div class="col-md-12 text-end">

                                @foreach ($q->question->choiceMultiple as $o)
                                @if($q->question->question_type == 'radio')
                            <input  readonly name="test[$q->question_id]" id="q_{{$o->id}}" type="{{ $q->question->question_type }}" value="{{ $o->option }}" @checked($q->user_answer==$o->option)>
                            @endif
                            @if($q->question->question_type == 'checkbox')
                            @php
                            
                            $checobox_values = explode('__',$q->user_answer);
                            
                           
                            
                            @endphp
                            <input  readonly name="test[$q->question_id]" id="q_{{$o->id}}" type="{{ $q->question->question_type }}" value="{{ $o->option }}" @checked(in_array($o->option,$checobox_values))>
                            @endif
                            <label for="q_{{$o->id}}">{{ $o->option }}</label>
                            
                            
                                @endforeach
<!-- 
                                    <input id="question1" type="text"
                                        class="form-control @error('question1') is-invalid @enderror" name="question1"
                                        value="{{ old('question1', $result->question) }}" required autocomplete="question"
                                        autofocus> -->

                                    @error('question1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            @endforeach

                            <!-- <div class="row mb-3">
                                <label for="question"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Question') }}</label>

                                <div class="col-md-6">
                                    <input id="question1" type="text"
                                        class="form-control @error('question1') is-invalid @enderror" name="question1"
                                        value="{{ old('question1', $result->question) }}" required autocomplete="question"
                                        autofocus>

                                    @error('question1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> -->


                           
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
