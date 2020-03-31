@extends('layouts.app')

@section('content')

@if (session('status'))
    <div class="alert alert-success floating-alert" role="alert">{{ session('status') }}</div>
@endif
<!-- <userleftnav></userleftnav> -->
<user :user="{{ $user }}"></user>
<!-- <userhelp></userhelp> -->
<!-- <userprofile></userprofile> -->
<!-- <usernotifications></usernotifications> -->
@endsection