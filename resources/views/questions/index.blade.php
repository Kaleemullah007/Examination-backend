@extends('layouts.app')
@section('content')
    <a href="{{ route('questions.create') }}"> Create Question</a>
    @if (session()->has('message'))
        <div class="alert text-center alert-{{ session('error') }}">
            {{ session('message') }}
        </div>
    @endif
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Question</th>
                <th scope="col">Answer</th>
                <th scope="col">Option</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 0;

            @endphp

            @foreach ($questions as $q)
                <tr>
                    <th scope="row">{{ ++$counter }}</th>
                    <td>{{ $q->question }}</td>
                    <td>{{ $q->correct_answer }}</td>
                    <td>

                        @foreach ($q->choiceMultiple as $o)
                            <input readonly checked type="{{ $q->question_type }}" value="{{ $o->option }}">
                            {{ $o->option }}
                            <a href="{{ route('options.edit', $o->id) }}">Edit Option</a>
                            <form action="{{ route('options.destroy', $o->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="page" id="page" value="{{ request('page') }}">
                                <button> Delete</button>
                            </form>
                            <br>
                        @endforeach
                    </td>
                    <td> <a href="{{ route('questions.addoption',$q->id) }}">Add
                            Option</a>

                        <a href="{{ route('questions.edit', $q->id) }}">Edit</a>

                        <form action="{{ route('questions.destroy', $q->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="page" id="page" value="{{ request('page') }}">
                            <button> Delete</button>
                        </form>

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <div class="container">
        {{ $questions->links() }}
    </div>
@endsection
