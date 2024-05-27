@extends('layouts.app')
@section('content')
    <a href="{{ route('papers.create') }}"> Create Paper</a>
    @if (session()->has('message'))
        <div class="alert text-center alert-{{ session('error') }}">
            {{ session('message') }}
        </div>
    @endif
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Descreiption</th>
                <th scope="col">Paper Time</th>
                <th scope="col">Question Count</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 0;

            @endphp
            @foreach ($papers as $paper)
                <tr>
                    <th scope="row">{{ ++$counter }}</th>
                    <td>{{ $paper->name }}</td>
                    <td>{{ $paper->description }}</td>
                    <td>{{ $paper->paper_time }}</td>
                    <td>{{ $paper->question_count }}</td>
                    <td>

                        <a href="{{ route('papers.edit', $paper->id) }}">Edit</a>

                        <form action="{{ route('papers.destroy', $paper->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="page" id="page" value="{{ request('page') }}">
                            <button> Delete</button>
                        </form>
                        <a href="{{ route('questions.shows', $paper->id) }}">View Questions</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="container">
        {{ $papers->links() }}
    </div>
@endsection
