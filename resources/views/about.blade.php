<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ secure_asset('images/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ secure_asset('images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ secure_asset('images/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ secure_asset('images/favicon-16x16.png') }}">

        <!-- Primary Meta Tags -->
        <title>Deixa Que Eu Busco | Juntos Somos Mais Fortes</title>
        <meta name="title" content="Deixa Que Eu Busco | Sobre">
        <meta name="description" content="Cadastre-se e fique a disposição de pessoas próximas que estão no grupo de risco do Covid-19. Um simples gesto pode fazer toda diferença.">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://deixaqueeubusco.com.br/">
        <meta property="og:title" content="Deixa Que Eu Busco | Sobre">
        <meta property="og:description" content="Cadastre-se e fique a disposição de pessoas próximas que estão no grupo de risco do Covid-19. Um simples gesto pode fazer toda diferença.">
        <meta property="og:image" content="{{ secure_asset('images/logo.png') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="https://deixaqueeubusco.com.br/">
        <meta property="twitter:title" content="Deixa Que Eu Busco | Sobre">
        <meta property="twitter:description" content="Cadastre-se e fique a disposição de pessoas próximas que estão no grupo de risco do Covid-19. Um simples gesto pode fazer toda diferença.">
        <meta property="twitter:image" content="{{ secure_asset('images/logo.png') }}">

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Styles -->
        <style>

            body {
                padding: 0;
                margin: 0;
            }

            html, body, #mapid {
                width: 100%;
                height:100vh;
            }

            header{
                width: 100%;
                top: 0;
                z-index: 999;
                background: #ffffffe0;
                padding: 0;
            }

            .nav-link {
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                font-size: 12px;
                text-transform: uppercase;
                font-weight: bold;
                color: #EF3D4F;
                padding: 1px 0 !important;
            }

            .auth a {
                text-align: center;
            }

        </style>
    </head>

    <body>

        <div class="cover-container">
            <header class="masthead mb-auto">
                <div class="inner">
                    <nav class="nav nav-masthead justify-content-center">
                    <div class="col-sm-12 col-md-3">
                        <a class="nav-link" href="/"><img src="{{ secure_asset('images/logo-2.png') }}" width="150" style="margin: 0 auto;display: table;" alt="Deixa Que Eu Busco"></a>
                    </div>
                    <div class="auth col-sm-12 col-md-2 offset-md-7">
                        <a class="nav-link" href="/sobre">Sobre</a>
                        @if (Route::has('login'))
                            @auth
                                <a class="nav-link" href="{{ url('/home') }}">Minha Conta</a>
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Sair</a>    
                                <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                </form>
                            @else
                                <a class="nav-link" href="{{url('/facebook/redirect')}}" class="btn btn-primary">Seja um Voluntário ❤️</a>
                            @endauth
                        @endif
                        </div>
                    </nav>
                </div>
            </header>

            <div class="col-md-12">
                <h1>Como Surgiu o Deixa Que Eu Busco</h1>
                <p>
                    Meu nome é Cleverson Franco, trabalho como Engenheiro de Software, e em meio a essa situação de quarentena observei muitas pessoas colocando cartazes 
                    para ajudar vizinhos idosos com compras, então decidi transformar isso em um sistema <a href="https://github.com/cleversonferreira/deixaqueeubusco">Open Source</a> que pudesse centralizar todos os voluntários em um só lugar.
                </p>
                <hr>
                <h2>Como Funciona</h2>
                <h3>Voluntários</h3>
                <img class="img-fluid img-thumbnail" src="{{ asset('images/voluntarios.png') }}" alt="">
                <h3>Idosos</h3>
                <img class="img-fluid img-thumbnail" src="{{ asset('images/idosos.png') }}" alt="">
                <hr>
                <h2>Voluntários do Projeto</h2>
                <p>Os voluntários abaixo ajudaram o projeto de forma incrível, fazendo ele criar uma identidade e se tornar melhor.</p>
                <br>
                <h3><strong><a target="_blank" href="https://www.facebook.com/tarcisio.z.ferraz">Tarcisio Ferraz</a></strong></h3>
                <h4>Engenheiro de Software</h4>
                <p>Ajudou imensamente em melhorias e correções de código</p>
                <br>
                <h3><strong><a target="_blank" href="https://www.facebook.com/gr.guireis">Guilherme Dos Reis</a></strong></h3>
                <h4>Designer</h4>
                <p>Fez um trabalho incrível criando uma logomarca para o projeto</p>
                <br>
                <h3><strong><a target="_blank" href="https://www.facebook.com/evellyn.bz">Evellyn Zimmermann</a></strong></h3>
                <h4>Designer</h4>
                <p>Criou banners que ajudaram imensamente na divulgação e propagação do projeto</p>
                <br>

            </div>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-161551353-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-161551353-1');
        </script>

    </body>
</html>
