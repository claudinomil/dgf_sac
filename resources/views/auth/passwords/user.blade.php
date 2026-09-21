@extends('layouts.master-without-nav')

@section('title')
{{ __('Recuperar senha') }}
@endsection

@section('content')
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-12 col-md-6 p-md-5">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center mb-4">
                    {{ __('Recuperar senha') }}
                </h4>

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('forgot_password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">{{ __('Usuário') }}</label>
                        <input type="text" name="user" class="form-control" required>
                    </div>

                    <button class="btn btn-primary w-100">{{ __('Enviar link de recuperação') }}</button>

                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}" class="text-muted text-decoration-none"><i class="mdi mdi-login me-1"></i>{{ __('Fazer Login') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
