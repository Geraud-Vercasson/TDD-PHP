@extends('base')

@section('title', 'projects')
@section('content')
    <h2>Liste des projets</h2>
    <ul class="project-list">
        @foreach($projects as $project)
            <li>
                <h3><a href="{{'/project/'.$project->id}}">{{$project->name}}</a></h3>
                <p>{{$project->description}}</p>
            </li>
        @endforeach
    </ul>
@endsection