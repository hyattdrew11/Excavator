@extends('layouts.app')

@section('content')

@if (session('status'))
    <div class="alert alert-success floating-alert" role="alert">{{ session('status') }}</div>
@endif
<vue-progress-bar></vue-progress-bar>
<adminleftnav :connections="{{ $connections }}"></adminleftnav>
<smtp 
	:admin="{{ $admin }}"
	:users="{{ $users }}" 
	:connections="{{ $connections }}" 
	:jobs="{{ $jobs }}"
	:smtp_host="'{{ env('MAIL_HOST') }}'"
	:smtp_port="'{{ env('MAIL_PORT') }}'"
	:smtp_username="'{{ env('MAIL_USERNAME') }}'"
	:smtp_encryption="'{{ env('MAIL_ENCRYPTION') }}'"
	:smtp_from_address="'{{ env('MAIL_FROM_ADDRESS') }}'"
	:smtp_from_name="'{{ env('MAIL_FROM_NAME') }}'"
	:smtp_report_target="'{{ env('MAIL_REPORT_TARGET') }}'"
	>
	</smtp>
<!-- <adminhelp></adminhelp> -->
<!-- <adminprofile></adminprofile> -->
<!-- <adminnotifications></adminnotifications> -->
@endsection
