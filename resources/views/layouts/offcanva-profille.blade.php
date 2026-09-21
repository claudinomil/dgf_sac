<div class="offcanvas offcanvas-start w-100" tabindex="-1" id="offcanvaProfille" aria-labelledby="offcanvaProfilleLabel">
    <div class="offcanvas-header position-relative d-flex align-items-center">
        <img src="{{ asset('assets/images/logo_cbmerj_dgf_branco.png') }}" height="50" />
        <h3 class="offcanvas-title position-absolute start-50 translate-middle-x text-white" id="offcanvaProfilleLabel">Perfil do Usuário</h3>
        <a href="#" class="btn-close ms-auto" data-bs-dismiss="offcanvas"><i class="fa fa-close font-size-20 text-white"></i></a>
    </div>
    <div class="offcanvas-body bg-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <img src="{{ asset('/assets/images/users/avatar-0.png') }}" class="rounded-circle mb-3 url_user_avatar" width="120" id="profilleImgAvatar">
                            <h6 id="profilleName"></h6>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body font-size-12">
                            <h6 class="card-title mb-4">Informações</h6>
                            <div class="table-responsive">
                                <table class="table table-nowrap mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Nome :</th>
                                            <td id="profilleInformacaoName"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Usuário :</th>
                                            <td id="profilleInformacaoUser"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">E-mail :</th>
                                            <td id="profilleInformacaoEmail"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Grupo :</th>
                                            <td id="profilleInformacaoGrupoName"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Situação :</th>
                                            <td id="profilleInformacaoSituacaoName"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Usuário Tipo :</th>
                                            <td id="profilleInformacaoUserTipoName"></td>
                                        </tr>
                                        <tr class="profille_user_tipo_militar">
                                            <th scope="row">Militar RG :</th>
                                            <td id="profilleInformacaoMilitarRg"></td>
                                        </tr>
                                        <tr class="profille_user_tipo_militar">
                                            <th scope="row">Militar Nome :</th>
                                            <td id="profilleInformacaoMilitarNome"></td>
                                        </tr>
                                        <tr class="profille_user_tipo_militar">
                                            <th scope="row">Militar Posto/Graduação :</th>
                                            <td id="profilleInformacaoMilitarPostoGraduacao"></td>
                                        </tr>
                                        <tr class="profille_user_tipo_militar">
                                            <th scope="row">Militar Situação :</th>
                                            <td id="profilleInformacaoMilitarSituacao"></td>
                                        </tr>
                                        <tr class="profille_user_tipo_militar">
                                            <th scope="row">Militar Quadro Especialidade :</th>
                                            <td id="profilleInformacaoMilitarQuadroEspecialidade"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3 profille_user_logado">
                        <div class="card-body font-size-12">
                            <h6>{{ __('Alterar avatar') }}</h6>
                            <form id="frm_profille_update_avatar" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label>{{ __('Avatar') }}</label>
                                    <input type="file" name="profille_avatar" id="profille_avatar" class="form-control form-control-sm" accept="image/*">
                                </div>

                                <button type="button" class="btn btn-primary btn-sm" onclick="crudOffCanvaProfilleUpdateAvatar()">{{ __('Alterar avatar') }}</button>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-3 profille_user_logado">
                        <div class="card-body font-size-12">
                            <h6>{{ __('Alterar senha') }}</h6>

                            <form id="frm_profille_update_password">
                                @csrf

                                <div class="row">
                                    <div class="col-12 col-md-4 mb-3">
                                        <label>{{ __('Senha atual') }}</label>
                                        <input type="password" name="profille_current_password" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label>{{ __('Nova senha') }}</label>
                                        <input type="password" name="profille_password" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label>{{ __('Confirmar senha') }}</label>
                                        <input type="password" name="profille_password_confirmation" class="form-control form-control-sm">
                                    </div>
                                </div>

                                <button type="button" class="btn btn-warning btn-sm" onclick="crudOffCanvaProfilleUpdatePassword()">{{ __('Alterar senha') }}</button>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body font-size-12">
                            <h6>{{ __('Transações') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>Larry</td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
