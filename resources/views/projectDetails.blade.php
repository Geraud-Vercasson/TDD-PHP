@extends('base');

@section('title', $project->name);

@section('content')
    <div class="row">
        <div class="project-details">
            <h2>
                {{$project->name}}
            </h2>
            <h4>depuis le {{$project->created_at}}</h4>
            <p>{{$project->description}}</p>
        </div>
        <div class="author-column">
            <div class="author"><h2><img src="{{asset('images/user-default.png')}}" alt=""> {{$project->user->name}}</h2></div>
            <div class="edit-form">
                @include('formContent', ['formAction' => '/project/edit/' . $project->id,
                                        'projectName' => $project->name,
                                        'projectDescription' => $project->description])
            </div>
        </div>
    </div>

@endsection