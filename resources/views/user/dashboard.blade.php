@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8 my-12">

    <profile-page :user="{{ json_encode(Auth::user()) }}"></profile-page>

</div>
@endsection
