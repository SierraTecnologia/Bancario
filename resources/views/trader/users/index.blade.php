@extends('layouts.page')

@section('title', 'Orders')

@section('content_header')
    <h1>Users</h1>
@stop

@section('css')

@stop

@section('js')

@stop

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif

    @include('root.users.numbers', [
        'adminUsers' => $adminUsers->count(),
        'businessUsers' => $businessUsers->count(),
        'organizerUsers' => $organizerUsers->count(),
        'customerUsers' => $customerUsers
    ])

  {{-- @include('root.users.table', ['users' => $adminUsers]) --}}

  @include('root.users.table-business', ['users' => $businessUsers])

  {{-- @include('root.users.table-organizer', ['users' => $organizerUsers]) --}}
  
<div>
@endsection