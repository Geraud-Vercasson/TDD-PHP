@extends('base');

@section('title', 'Nouveau projet');

@section('content')
    <div class="row justify-content-center">
        <div class="py-4 col-6">
            @include('formContent', ['formAction' => '/project/create',
                                    'projectName' => '',
                                    'projectDescription' => ''])
        </div>
    </div>

@endsection