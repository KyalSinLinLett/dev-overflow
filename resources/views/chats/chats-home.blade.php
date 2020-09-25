@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chats</h2>
    <hr>

    @if(session()->has('success'))
        <div id="message_id" class="card px-4 py-4 bg-success text-light">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div id="message_id" class="card px-4 py-4 bg-danger text-light">
            {{ session()->get('error') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <strong>Have a chat with your friends</strong>
                </div>

                <div class="card-body p-1 mb-2" id="app">
                    <chat-app :user="{{ Auth::user() }}"></chat-app>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
