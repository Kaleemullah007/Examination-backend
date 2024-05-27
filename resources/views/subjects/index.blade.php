@extends('layouts.app')
@section('content')
    <a href="{{ route('subjects.create') }}">Create Subject</a>
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
                <th scope="col">Papers</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 0;

            @endphp
            @foreach ($subjects as $subject)
                <tr>
                    <th scope="row">{{ ++$counter }}</th>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->papers_count }}</td>
                    <td> <a href="{{ route('papers.shows', $subject->id) }}">View Papers</a>
                        <a href="{{ route('subjects.edit', $subject->id) }}">Edit</a>

                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="post">
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
        {{ $subjects->links() }}
    </div>
@endsection
