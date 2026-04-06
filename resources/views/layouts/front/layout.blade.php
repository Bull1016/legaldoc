<!DOCTYPE html>
<html lang="{{ session()->get('locale') ?? app()->getLocale() }}">

<head>
    <title>@yield('title') | {{ optional($organisation)->nameOr }}</title>
    <link rel="icon" href="{{ asset('storage/' . optional($organisation)->picOr) }}" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta
        content="legal-doc, admin legal-doc, admin legal-doc login, legal-doc benin admin, admin dash, admin dashboard, tableau de bord legal-doc, dahboard legal-doc, cotonou legal-doc, cotonou legal-doc admin, legal-doc cotonou"
        name="description">
    <meta
        content="legal-doc, admin legal-doc, admin legal-doc login, legal-doc benin admin, admin dash, admin dashboard, tableau de bord legal-doc, dahboard legal-doc, cotonou legal-doc, cotonou legal-doc admin, legal-doc cotonou"
        name="keywords">
    <meta content="{{ config('variables.creatorName') }}" name="author">
    <!-- CSS Files
    ================================================== -->
    @include('layouts.front.styles')
</head>

<body>
    @php
        use Illuminate\Support\Facades\Route;
        $currentRoute = Route::currentRouteName();
    @endphp

    <div id="wrapper">
        <a href="#" id="back-to-top"></a>

        <!--===== PRELOADER STARTS =======-->
        <div class="se-pre-con preloader6">
            <div class="outer">
                <div class="middle">
                    <div class="inner">

                        <div class="Preloader-icon">
                            <img src="{{ asset('front/assets/img/logo/preloader.svg') }}" alt="">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--===== PRELOADER ENDS =======-->

        <!--===== PROGRESS STARTS =======-->
        <div class="paginacontainer">
            <div class="progress-wrap">
                <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                    <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
                </svg>
            </div>
        </div>
        <!--===== PROGRESS ENDS =======-->

        <!-- header begin -->
        @include('layouts.front.header')
        <!-- header close -->

        <!-- content begin -->
        @yield('content')
        <!-- content close -->

        <!-- footer begin -->
        @include('layouts.front.footer')
        <!-- footer close -->
    </div>



    <!-- Javascript Files
    ================================================== -->
    @include('layouts.front.scripts')
</body>

</html>
