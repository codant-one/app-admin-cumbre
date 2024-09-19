<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>

    <!--begin::Fonts-->
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" as="style">
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link rel="stylesheet" href="{{ asset('/plugins/global/plugins.bundle.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/css/style.bundle.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/custom/styles/main.css') }}">
    <!--end::Global Stylesheets Bundle-->

    <link rel="icon" type="image/png" href="{{ env('DOMAIN_FAVICON_URL') }}">
    @php
        $url = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' viewBox='0 0 1000 1000'%3E%3Cdefs%3E%3CradialGradient id='a' cx='500' cy='500' r='97.4%25' gradientUnits='userSpaceOnUse'%3E%3Cstop offset='0' stop-color='%23B62D44'/%3E%3Cstop offset='1' stop-color='%23333333'/%3E%3C/radialGradient%3E%3CradialGradient id='b' cx='500' cy='500' r='0%25' gradientUnits='userSpaceOnUse'%3E%3Cstop offset='0' stop-color='%23FFFFFF' stop-opacity='1'/%3E%3Cstop offset='1' stop-color='%23FFFFFF' stop-opacity='0'/%3E%3C/radialGradient%3E%3C/defs%3E%3Crect fill='url(%23a)' width='1000' height='1000'/%3E%3Cg fill='none' stroke='%23B62D44' stroke-width='2' stroke-miterlimit='10' stroke-opacity='0.28'%3E%3Crect x='12.5' y='12.5' width='975' height='975'/%3E%3Crect x='25' y='25' width='950' height='950'/%3E%3Crect x='37.5' y='37.5' width='925' height='925'/%3E%3Crect x='50' y='50' width='900' height='900'/%3E%3Crect x='62.5' y='62.5' width='875' height='875'/%3E%3Crect x='75' y='75' width='850' height='850'/%3E%3Crect x='87.5' y='87.5' width='825' height='825'/%3E%3Crect x='100' y='100' width='800' height='800'/%3E%3Crect x='112.5' y='112.5' width='775' height='775'/%3E%3Crect x='125' y='125' width='750' height='750'/%3E%3Crect x='137.5' y='137.5' width='725' height='725'/%3E%3Crect x='150' y='150' width='700' height='700'/%3E%3Crect x='162.5' y='162.5' width='675' height='675'/%3E%3Crect x='175' y='175' width='650' height='650'/%3E%3Crect x='187.5' y='187.5' width='625' height='625'/%3E%3Crect x='200' y='200' width='600' height='600'/%3E%3Crect x='212.5' y='212.5' width='575' height='575'/%3E%3Crect x='225' y='225' width='550' height='550'/%3E%3Crect x='237.5' y='237.5' width='525' height='525'/%3E%3Crect x='250' y='250' width='500' height='500'/%3E%3Crect x='262.5' y='262.5' width='475' height='475'/%3E%3Crect x='275' y='275' width='450' height='450'/%3E%3Crect x='287.5' y='287.5' width='425' height='425'/%3E%3Crect x='300' y='300' width='400' height='400'/%3E%3Crect x='312.5' y='312.5' width='375' height='375'/%3E%3Crect x='325' y='325' width='350' height='350'/%3E%3Crect x='337.5' y='337.5' width='325' height='325'/%3E%3Crect x='350' y='350' width='300' height='300'/%3E%3Crect x='362.5' y='362.5' width='275' height='275'/%3E%3Crect x='375' y='375' width='250' height='250'/%3E%3Crect x='387.5' y='387.5' width='225' height='225'/%3E%3Crect x='400' y='400' width='200' height='200'/%3E%3Crect x='412.5' y='412.5' width='175' height='175'/%3E%3Crect x='425' y='425' width='150' height='150'/%3E%3Crect x='437.5' y='437.5' width='125' height='125'/%3E%3Crect x='450' y='450' width='100' height='100'/%3E%3Crect x='462.5' y='462.5' width='75' height='75'/%3E%3Crect x='475' y='475' width='50' height='50'/%3E%3Crect x='487.5' y='487.5' width='25' height='25'/%3E%3C/g%3E%3Crect fill-opacity='0.28' fill='url(%23b)' width='1000' height='1000'/%3E %3C/svg%3E";
        $url = str_replace('%23B62D44', ( Request::is('admin') || Request::is('admin/*') ) ? env('DOMAIN_BG_PRIMARY_COLOR') : env('DOMAIN_CLIENT_BG_PRIMARY_COLOR'), $url);
        $url = str_replace('%23333333', ( Request::is('admin') || Request::is('admin/*') ) ? env('DOMAIN_BG_SECONDARY_COLOR') : env('DOMAIN_CLIENT_BG_SECONDARY_COLOR'), $url);
    @endphp
    <style type="text/css">
        :root {
            --primary: {{ env('DOMAIN_PRIMARY_COLOR')  }};
            --secondary: {{ env('DOMAIN_SECONDARY_COLOR') }};
            --pelorous: #EFFBFC;
            --neptune-050: #F2F9F9;
            --neptune-200: #BFE0E2;
            --neptune-400: #6AB0B5;
            --neptune-600: #3C757E;
            --neptune-800: #325158;
            --neptune-950: #1A2D32;
        }

        .text-link {
            color: white;
        }

        .text-link:hover {
            color: var(--secondary) !important;
        }

        .main-header{
            background-color: var(--primary) !important;
        }

        .aside_{
            width:100%; margin-top: -200px; height: 440px;
        }

        .welcome{
            margin-top: -100px;
        }
        @media (max-width: 1024px){
            .aside_{
                width:100%; margin-top: 0px;  height: 300px;
            }
            .welcome{
                margin-top: 0px;
            }
        }
    </style>

    @yield('page-styles')
</head>

<body class="text-left bg-body">

    <!-- Pre Loader Strat  -->
    <div class="loadscreen" id="preloader">
        <div class="loader spinner-bubble spinner-bubble-primary">
        </div>
    </div>
    <!-- Pre Loader end  -->

    @yield('page-content')

    <script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('/js/scripts.bundle.js') }}"></script>

    @yield('page-js')
</body>

</html>
