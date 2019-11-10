<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="http://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                        <a href="{{ route('driver.login') }}">Login as a driver</a>

                        @if (Route::has('register'))
                            <a href="{{ route('driver.register') }}">Register as a driver</a>
                        @endif
                    @endauth
                </div>
            @endif


            <div class="content">
                <div class="row">
                    <h1>List of Monopolists</h1>
                    <select id="select_duration">
                        <option value="all_time">All Time</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
                <br>
                    <table class="table table-bordered table-hover" id="monopolies">

                        <thead>

                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>vehical type</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                    </table>
                <script src="{{asset('js/vendors/jquery.js')}}"></script>
                    <script>let base_url = "{{url('/')}}";</script>
                    <script type="application/javascript" src="http://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
                    <script src="{{asset('js/datatable.js')}}"></script>

            </div>
        </div>
    </body>
</html>
