@extends('layouts.layout')

@section('content')
    @vite('resources/css/add_film.css')

    <div class="add-film-page">
        <form action="" method="POST">
            <label for="title">Title</label>
            <input type="text" id="title">

            <button>Add new film</button>
        </form>
    </div>


@endsection
