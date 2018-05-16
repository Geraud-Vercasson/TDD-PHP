<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            @yield('title')
        </title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>


        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .full-width {
                width: 90vw;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .links {
                display: flex;
                align-items: center;
            }

            .flex-justify {
                display: flex;
                justify-content: space-between;
                margin: auto;
            }

            .title {
                font-weight: bold;
                font-size: 24pt;
            }
            .project-list {
                list-style: none;
                text-align: left;
            }
            .row{
                display: flex;
                justify-content: space-between;
            }
            .project-details {
                text-align: left;
                width: 60%;
                padding: 10px;
                margin: 0px 15px;
            }
            .author-column{
                width: 30%;
                padding: 10px;
            }
            .author {
                width: 70%;
                margin: auto;
                padding:15px 5px;
                border: 2px solid black;
            }
            .author>h2 {
            }
            .author > h2 >img {
                height: 30px;
                vertical-align: bottom;
            }
            .edit-form {
                width: 90%;
                margin: 20px auto;
                border: 1px solid lightgray;
                padding: 5px;
            }

        </style>
    </head>
    <body>
        <div class=" position-ref full-height">
            <div class="full-width flex-justify">
                <h1 class="title">Don en ligne</h1>
                <span class="links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                        <a href="{{url('/project/add')}}">Nouveau Projet</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </span>
            </div>


            <div class="content">
                @yield('content')
            </div>
        </div>
    </body>
</html>
