@extends('layouts.app')
@section('content')
<a href="{{ route('papers.create') }}"> Create Paper</a>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Descreiption</th>
                <th scope="col">Question Count</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 0;

            @endphp
            @foreach ($papers as $paper_)
                @foreach ($paper_->papers as $paper)
                    <tr>
                        <th scope="row">{{ ++$counter }}</th>
                        <td>{{ $paper->name }}</td>
                        <td>{{ $paper->description }}</td>
                        <td>{{ $paper->question_count }}</td>
                        <td>
                            <a href="{{ route('questions.shows', $paper->id) }}">View Questions</a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <div class="container">
        {{ $papers->links() }}
    </div>
@endsection
