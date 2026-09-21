@extends('layouts.master-without-nav')

@section('title')
{{ __('Nova senha') }}
@endsection

@section('content')
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-12 col-md-6 p-md-5">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center mb-4">
                    {{ __('Nova senha') }}
                </h4>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('forgot_password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="mb-3">
                        <label>{{ __('Nova senha') }}</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>{{ __('Confirmar senha') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100">{{ __('Alterar senha') }}</button>

                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}" class="text-muted text-decoration-none"><i class="mdi mdi-login me-1"></i>{{ __('Fazer Login') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
