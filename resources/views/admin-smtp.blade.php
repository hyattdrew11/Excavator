@extends('layouts.app')

@section('content')

@if (session('status'))
    <div class="alert alert-success floating-alert" role="alert">{{ session('status') }}</div>
@endif
<adminleftnav :connections="{{ $connections }}"></adminleftnav>
<smtp :admin="{{ $admin }}" :users="{{ $users }}" :connections="{{ $connections }}" :jobs="{{ $jobs }}"></smtp>
<!-- <adminhelp></adminhelp> -->
<!-- <adminprofile></adminprofile> -->
<!-- <adminnotifications></adminnotifications> -->
@endsection
