@extends('layouts.app')
@section('content')
    @if (session()->has('message'))
        <div class="alert text-center alert-{{ session('error') }}">
            {{ session('message') }}
        </div>
    @endif
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Applicant Name</th>
                <th scope="col">Subject Name</th>
                <th scope="col">Paper Name</th>
                <th scope="col">Correct</th>
                <th scope="col">Wrong</th>
                <th scope="col">Attempts</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 0;

            @endphp
          
            @foreach ($results as $q)
                <tr>
                    <th scope="row">{{ ++$counter }}</th>
                    <td>{{ ucfirst($q->user->name) }}</td>
                    <td>{{ $q->subject->name }}</td>
                    <td>{{ $q->paper->name }}</td>
                    <td>{{ $q->correct_answer }}</td>
                    <td>{{ $q->wrong_answer }}</td>
                    <td>{{ $q->user_attempts }}</td>
                    <td>{{ ucfirst($q->status) }}</td>
                    <td>
                        <a href="{{route('results.show',$q->id)}}">View Result</a> <br>
                        <a href="{{route('results.edit',$q->id)}}">Edit Result</a>
                </td>
                   
                </tr>
            @endforeach

        </tbody>
    </table>
    <div class="container">
        {{ $results->links() }}
    </div>
@endsection
