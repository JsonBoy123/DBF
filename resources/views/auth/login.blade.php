@extends('layouts.dbf')

@section('content')

<link href="{{ asset('dbf-style/css/login.css') }}" rel="stylesheet">
<div class="row">
    <div align="center" class="col-md-12" >
        <img src="{{ asset('dbf-style/images/dbflogo.png') }}" style="margin-top: 5%">
    </div>

    <div id="login" class="col-md-12">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form action="{{ route('login') }}" method="post" accept-charset="utf-8">
                @csrf 
                <div id="container">
                    <div align="center" style="color:red">
                        @error('email')
                            {{ $message }}
                        @enderror
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>

                    <div id="login_form">
                        <div class="input-group">
                            <span class="input-group-addon input-sm"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <input  id="email"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon input-sm"><i class="fa fa-lock" aria-hidden="true"></i></span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                        </div>        
                        <input class="btn btn-primary btn-block" type="submit" name="loginButton" value="Go">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>

@endsection
