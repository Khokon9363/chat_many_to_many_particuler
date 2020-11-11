@extends('layouts.app')

@section('content')
<input type="hidden" value="{{ Auth::user()->id }}" id="authUserId">
<div class="container">
       <chat-component></chat-component>
</div>
        
@endsection
