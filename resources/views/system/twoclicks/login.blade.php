@extends('system.twoclicks.layouts.auth')

@section('content')
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
            <!--begin::Form-->
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <!--begin::Wrapper-->
                <div class="w-lg-500px p-10">
                    <!--begin::Form-->
                    <form class="form w-100" method="POST" action="{{ route('login') }}" id="kt_sign_in_form">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-gray-900 fw-bolder mb-3">Entrar</h1>
                            <!--end::Title-->
                            <!--begin::Subtitle-->
                            <div class="text-gray-500 fw-semibold fs-6">Acesse o painel de gerenciamento</div>
                            <!--end::Subtitle-->
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="E-mail" name="email" autocomplete="off" value="alex@twoclicks.com.br"
                                class="form-control bg-transparent" value="{{ old('email') }}" />
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-3 position-relative">
                            <input type="password" placeholder="Senha" name="password" autocomplete="off" value="Alex1985@"
                                class="form-control bg-transparent pe-13" id="password" />
                            <span class="btn btn-sm btn-icon position-absolute translate-middle-y top-50 end-0 me-2"
                                onclick="var p=document.getElementById('password');var i=this.querySelector('i');if(p.type==='password'){p.type='text';i.classList.replace('ki-eye-slash','ki-eye');}else{p.type='password';i.classList.replace('ki-eye','ki-eye-slash');}">
                                <i class="ki-outline ki-eye-slash fs-2 text-gray-500"></i>
                            </span>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <!--begin::Lembrar-me-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="remember" value="1" />
                                <span class="form-check-label text-gray-700 fs-6">Lembrar-me</span>
                            </label>
                            <!--end::Lembrar-me-->
                            <!--begin::Link-->
                            <a href="#" class="link-primary">Esqueci a senha</a>
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Submit button-->
                        <div class="d-grid mb-10">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                <span class="indicator-label">Entrar</span>
                                <span class="indicator-progress">Aguarde...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Submit button-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Form-->
            <!--begin::Footer-->
            <div class="w-lg-500px d-flex flex-stack px-10 mx-auto">
                <div class="text-gray-500 fw-semibold fs-7">
                    <span>2012 - {{ date('Y') }}&copy;</span>
                    <a href="https://twoclicks.com.br" target="_blank"
                        class="text-gray-800 text-hover-primary d-inline-flex align-items-center gap-1 ms-1">
                        <i class="ki-solid ki-click fs-4"></i>
                        TwoClicks Tecnologia
                    </a>
                </div>
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Body-->
        <!--begin::Aside-->
        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
            style="background-image: url({{ asset('system/metronic8/demo34/assets/media/misc/auth-bg.png') }})">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                <!--begin::Logo-->
                <a href="{{ url('/') }}" class="mb-0 mb-lg-12">
                    <img alt="TwoClicks" src="{{ asset('system/metronic8/demo34/assets/media/logos/logo-tc-light.svg') }}"
                        class="h-60px h-lg-75px" />
                </a>
                <!--end::Logo-->
                <!--begin::Image-->
                <img class="d-none d-lg-block mx-auto w-200px w-md-50 w-xl-400px mb-10 mb-lg-20"
                    src="{{ asset('system/metronic8/demo34/assets/media/misc/auth-screens.png') }}" alt="" />
                <!--end::Image-->
                <!--begin::Title-->
                <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">Gerencie suas plataformas em um
                    só lugar</h1>
                <!--end::Title-->
                <!--begin::Text-->
                <div class="d-none d-lg-block text-white fs-base text-center">
                    Multi-tenant, modular e escalável.<br />
                    A base tecnológica para seus produtos SaaS.
                </div>
                <!--end::Text-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Aside-->
    </div>
@endsection
