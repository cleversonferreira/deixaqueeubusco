@extends('layouts.app')

@section('content')


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
    </div>



    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>
   
    <!-- Adicionando Javascript -->
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

@endsection
