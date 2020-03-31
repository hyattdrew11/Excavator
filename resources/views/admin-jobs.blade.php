@extends('layouts.app')

@section('content')

@if (session('status'))
    <div class="alert alert-success floating-alert" role="alert">{{ session('status') }}</div>
@endif
<adminleftnav></adminleftnav>
<jobs :admin="{{ $admin }}" :users="{{ $users }}" :connections="{{ $connections }}" :jobs="{{ $jobs }}"></jobs>
<!-- <adminhelp></adminhelp> -->
<!-- <adminprofile></adminprofile> -->
<!-- <adminnotifications></adminnotifications> -->
@endsection
