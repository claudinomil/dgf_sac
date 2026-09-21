@extends('layouts.master-without-nav')

@section('title')
{{ __('Login') }}
@endsection

@section('body')
<body style="background-color: #C8D1FA;">
    @endsection

    @section('content')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-11 col-md-8 col-lg-6 col-xl-4">
                    <div class="card shadow-lg overflow-hidden">
                        <div class="lo-bg-thema">
                            <div class="row">
                                <div class="text-white p-4">
                                    <h5>CBMERJ - DGF - SAC</h5>
                                    <p>{{ __('Sistema de Administração e Controle.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img src="{{ asset('/assets/images/image_logo_cbmerj.png') }}" alt="" class="rounded-circle" height="65">
                                    </span>
                                </div>
                            </div>
                            <div>

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form class="form-horizontal" method="POST" action="/login">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Usuário') }}</label>
                                        <input type="text" class="form-control" id="user" name="user" placeholder="Entre com o Usuário" value="27335" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Senha') }}</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Entre com a Senha" value="12345678" required>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary lo-bg-thema col-12" type="submit">{{ __('Login') }}</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        @if (Route::has('forgot_password.request'))
                                        <a href="{{ route('forgot_password.request') }}" class="text-muted text-decoration-none"><i class="mdi mdi-lock me-1"></i>{{ __('Esqueceu sua senha?') }}</a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="mt-4 text-center font-size-10">
                            <p>©
                                <script>document.write(new Date().getFullYear())</script> CBMERJ DGF.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
