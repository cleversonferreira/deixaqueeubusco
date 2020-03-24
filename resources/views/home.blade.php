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
                        <a class="nav-link" href="/"><img src="{{ asset('images/logo-2.png') }}" width="150" style="margin: 0 auto;display: table;" alt="Deixa Que Eu Busco"></a>
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
                <div class="container">
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                    @endif

                    <h1>Minhas Informações</h1>
                    <p>Preencha as informações abaixo para aparecer no mapa como um voluntário</p>
                    <span>Você só será listado no mapa quando estiver disponível, você pode mudar essa configuração a qualquer momento.</span>
                    <br>
                    <br>
                    <span>A localização exibida não será a a localização exata do endereço informado. Fique tranquilo. </span>
                    
                    <hr>
                    
                    <form  method="POST" action="{{route('data_store')}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$data->id}}"/>
                        <input type="hidden" name="lat" value="{{$data->lat}}"/>
                        <input type="hidden" name="long" value="{{$data->long}}"/>
                        <h2>Meu Status</h2>
                        <label>Disponível:</label>
                        <input {{$data->status == 'on' ? 'checked' : ''}} type="radio" name="status" class="on" value="on">
                        <label>Indisponível</label>
                        <input {{$data->status == 'off' ? 'checked' : ''}} type="radio" name="status" class="off" value="off">
                        <br/>
                        <h2>Informacões de Endereço</h2>
                        <input value="{{$data->cep}}" placeholder="CEP" name="cep" type="text" id="cep" value="" size="60" maxlength="9" /><br />
                        <input value="{{$data->street}}" placeholder="Rua" name="street" type="text" id="street" size="60" /><br />
                        <input value="{{$data->number}}" placeholder="Número" name="number" type="text" id="number" size="60" /><br />
                        <input value="{{$data->neighborhood}}" placeholder="Bairro" name="neighborhood" type="text" id="neighborhood" size="60" /><br />
                        <input value="{{$data->city}}" placeholder="Cidade" name="city" type="text" id="city" size="60" /><br />
                        <input value="{{$data->state}}" placeholder="Estado" name="state" type="text" id="state" size="60" /><br />
                        <h2>Informações de Contato</h2>
                        <input value="{{$data->whatsapp}}"   placeholder="WhatsApp" type="text" id="whatsapp" name="whatsapp">
                        <br/>
                        <br/>
                        <input type="submit" value="Atualizar Informações">
                    </form>
                    <br>
                </div>
            </div>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-161551353-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-161551353-1');
        </script>

        <script type="text/javascript" >
            $(document).ready(function() {

                $(".on").click(function(){
                    $(".off").removeAttr("checked");
                    $(".on").attr("checked", true);

                });
                $(".off").click(function(){
                    $(".on").removeAttr("checked");
                    $(".off").attr("checked", true);
                });

                $("#whatsapp")
                .mask("(99) 9999-9999?9")
                .focusout(function (event) {  
                    var target, phone, element;  
                    target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
                    phone = target.value.replace(/\D/g, '');
                    element = $(target);  
                    element.unmask();  
                    if(phone.length > 10) {  
                        element.mask("(99) 99999-999?9");  
                    } else {  
                        element.mask("(99) 9999-9999?9");  
                    }  
                });


                function limpa_formulário_cep() {
                    // Limpa valores do formulário de cep.
                    $("#street").val("");
                    $("#neighborhood").val("");
                    $("#city").val("");
                    $("#state").val("");
                }
                
                //Quando o campo cep perde o foco.
                $("#cep").blur(function() {

                    //Nova variável "cep" somente com dígitos.
                    var cep = $(this).val().replace(/\D/g, '');

                    //Verifica se campo cep possui valor informado.
                    if (cep != "") {

                        //Expressão regular para validar o CEP.
                        var validacep = /^[0-9]{8}$/;

                        //Valida o formato do CEP.
                        if(validacep.test(cep)) {

                            //Preenche os campos com "..." enquanto consulta webservice.
                            $("#street").val("carregando ...");
                            $("#neighborhood").val("carregando ...");
                            $("#city").val("carregando ...");
                            $("#state").val("carregando ...");

                            //Consulta o webservice viacep.com.br/
                            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                                if (!("erro" in dados)) {
                                    //Atualiza os campos com os valores da consulta.
                                    $("#street").val(dados.logradouro);
                                    $("#neighborhood").val(dados.bairro);
                                    $("#city").val(dados.localidade);
                                    $("#state").val(dados.uf);
                                } //end if.
                                else {
                                    //CEP pesquisado não foi encontrado.
                                    limpa_formulário_cep();
                                    alert("CEP não encontrado.");
                                }
                            });
                        } //end if.
                        else {
                            //cep é inválido.
                            limpa_formulário_cep();
                            alert("Formato de CEP inválido.");
                        }
                    } //end if.
                    else {
                        //cep sem valor, limpa formulário.
                        limpa_formulário_cep();
                    }
                });
            });
        </script>

    </body>
</html>