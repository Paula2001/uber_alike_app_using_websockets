@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Drivers available </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container">
                        <span>Your Position</span> <strong>{{$current_location_name}}</strong>
                        <span>, Target Position</span> <strong>{{$location_name}}</strong>
                        <button id="btn">send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        window.onload = function(){
            var websocket = new WebSocket("ws://127.0.0.90:1410/");
            websocket.onopen = function() {
                console.log('connected');
            }
            websocket.onmessage = function(e){
                console.log(JSON.parse(e.data));
            }
            document.getElementById('btn').onclick = function(){
                var messageJSON = {
                    chat_user: "pola",
                    chat_message: 22.3
                };
                websocket.send(JSON.stringify(messageJSON));
            }
        }
    </script>
@endsection
