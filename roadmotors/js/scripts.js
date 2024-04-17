$(document).ready(function(){
    
   //Máscaras
   $('.date').mask('00/00/0000');
   $('.time').mask('00:00:00');
   $('.date_time').mask('00/00/0000 00:00:00');
   $('.cep').mask('00000-000');
   $('.phone').mask('0000-0000');
   $('.phone_with_ddd').mask('(00) 0000-0000');
   $('.phone_br').mask('(00) 0 0000-0009', {clearIfNotMatch: true});
   $('.phone_us').mask('(000) 000-0000');
   $('.mixed').mask('AAA 000-S0S');
   $('.cpf').mask('000.000.000-00', {reverse: true});
   $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
   $('.money').mask('000.000.000.000.000,00', {reverse: true});
   $('.money2').mask("#.##0,00", {reverse: true});
   $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
     translation: {
       'Z': {
         pattern: /[0-9]/, optional: true
       }
     }
   });
   $('.ip_address').mask('099.099.099.099');
   $('.percent').mask('##0,00%', {reverse: true});
   $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
   $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
   $('.fallback').mask("00r00r0000", {
       translation: {
         'r': {
           pattern: /[\/]/,
           fallback: '/'
         },
         placeholder: "__/__/____"
       }
     });
   $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});

   //Pesquisa
   var procurarAtivo = $("#procurar-ativo").val();
   if(procurarAtivo == 1){
      $("#blog-pesquisa").css("display","unset");
      $('#blog-artigos, #blog-paginacao').hide();
   }else if(procurarAtivo == 2){
      $("#blog-pesquisa").css("display","unset");
      $('#blog-artigos, #blog-paginacao, #blog-side, #blog-descricao').hide();
      $("#blog-titulo").text('Pesquisa');
      // $("#blog-navegacao").text('Pesquisa');
   }

   // else{
      // $("#blog-pesquisa").hide();
   // }

   $(".btn-search, .img-search").on("click", function(e){
      e.preventDefault();
      if($(this).closest("form").find("input[name=q]").val() == ""){
         $(this).closest("form").find("input[name=q]").attr("style","border: 1px solid red !important");
         msgErro('Preencha o(s) campo(s) obrigatório(s)');
      }else{
         $(this).closest("form").find("input[name=q]").attr("style","border: 1px solid grey !important");
         $(this).closest("form").submit();
      }
   });

   //Formulários
   $("#enviar-newsletter").on("click",function(e){
      e.preventDefault();
      enviarFormEmail("newsletter",true);
   });

   $("#enviar-contato").on("click",function(e){
        e.preventDefault();
        enviarFormEmail("contato",true);
   });

   $("#enviar-contato2").on("click",function(e){
        e.preventDefault();
        enviarFormEmail("contato2",true);
    });

   //Trabalhe conosco
   var arquivo;
   $('#trabalhe-curriculo').change(function(){
      var filename = $(this).val();
      var extension = filename.replace(/^.*\./, '');

      arquivo = $(this)[0].files[0];

      $("#curriculo-name").text(arquivo.name);

      if (extension == filename) { 
          extension = '';
      }
      else{ 
          extension = extension.toLowerCase(); 
      }
     
      if(extension!='doc' && extension!='docx' && extension!='pdf'){
        msgErro('A extensão deste arquivo não é permitida!');
        $("#trabalhe-curriculo").val('');
        $("#curriculo-name").text('Anexar currículo');
        // $("#curriculo-name").css('border', '1px solid red');
        $("#curriculo-arquivo").css('border', '1px solid red');
        return false;
      }

      var tamanhoMaximo ;
      tamanhoMaximo = ($("#maxFileSize").val())*1000000; 
      if($(this)[0].files[0].size >  tamanhoMaximo){
          msgErro('Arquivo muito grande!');
          $("#curriculo-name").text('Anexar currículo');
          $("#curriculo-arquivo").css('border', '1px solid red');
          return false;
      }
   });
  
   $("#enviar-trabalhe-conosco").on("click", function(e){
        e.preventDefault();
        var filename = $('#trabalhe-curriculo').val();
        var extension = filename.replace(/^.*\./, '');
        var valida = validaForm({
            form: $("form#form-trabalhe-conosco"),
            notValidate: true,
            validate: true
        });
        var valida = true;

        var formdata = new FormData();
        formdata.append("nome", $('#trabalhe-nome').val());
        formdata.append("email", $('#trabalhe-email').val());
        formdata.append("telefone", $('#trabalhe-telefone').val());
        formdata.append("mensagem", $('#trabalhe-mensagem').val());
        formdata.append("idarea_pretendida", $('#trabalhe-area').val());
        formdata.append("arquivo", arquivo);

        if(valida == false){
            msgErro('E-mail inválido');
            $("#form-trabalhe-conosco input[name='email']").val('');
        }else{
            arquivo = $('#trabalhe-curriculo')[0].files[0];

            if (extension == filename) { 
                extension = '';
            }
            else{ 
                extension = extension.toLowerCase(); 
            }
           
            if(extension!='doc' && extension!='docx' && extension!='pdf'){
              msgErro('A extensão deste arquivo não é permitida!');
              $("#trabalhe-curriculo").val('');
              $("#curriculo-name").text('Anexar currículo');
              $("#curriculo-arquivo").css('border', '1px solid red');
              valida = false;
              return false;
            }

            var tamanhoMaximo;
            tamanhoMaximo = ($("#maxFileSize").val())*1000000; 
            if($('#trabalhe-curriculo')[0].files[0].size >  tamanhoMaximo){
                msgErro('Arquivo muito grande!');
                $("#trabalhe-curriculo").val('');
                $("#curriculo-name").text('Anexar currículo');
                $("#curriculo-arquivo").css('border', '1px solid red');
                valida = false;
                return false;
            }

            var valida = validaForm({
                form: $("form#form-trabalhe-conosco"),
                notValidate: true,
                validate: true,
            });
            if (valida) {
                $.ajax({
                    url: 'admin/trabalhe_conosco_script.php?ajax=true&opx=cadastroTrabalhe_conosco',
                    type: 'post',
                    dataType: 'json',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    beforeSend:function(){
                        Loader.show();
                    }
                }).done(function (e) {
                    Loader.hide();
                    if (e.status) {
                        msgSucesso('Seu currículo foi enviado com sucesso!');
                        $('form#form-trabalhe-conosco')[0].reset();
                        setTimeout(function(){
                            document.location.reload(true)
                        }, 1200)
                    } else {
                        msgErro('Falha ao enviar formulário!');
                    }
                });
            }
        }
    });

   //Blog comentário
   $("#enviar-blog-comentario").on("click", function(e){
        e.preventDefault();
        var formData = new FormData($('#form-blog-comentario')[0]);
        var valida = validaForm({
            form: $("form#form-blog-comentario"),
            notValidate: true,
            validate: true
        });
        var valida = validateEmail($("#form-blog-comentario input[name='email']").val());
        // var valida = true;
        if(valida == false){
            msgErro('E-mail inválido');
            $("#form-blog-comentario input[name='email']").val('');
            $("#form-blog-comentario input[name='email']").addClass("border-error");
        }else{
            $("#form-blog-comentario input[name='email']").removeClass('border-error').addClass("border-complete");
            var valida = validaForm({
                form: $("form#form-blog-comentario"),
                notValidate: true,
                validate: true
            });
            if (valida) {
                $.ajax({
                    url: 'admin/blog_comentarios_script.php?opx=cadastroBlog_comentarios&ajax=true',
                    type: 'post',
                    dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    // data: $('form#form-blog-comentario').serialize(),
                    beforeSend:function(){
                        Loader.show();
                    }
                }).done(function (e) {
                    Loader.hide();
                    if (e.status) {
                        msgSucesso('Seu Comentário foi enviado com sucesso!');
                        $('form#form-blog-comentario')[0].reset();
                        setTimeout(function(){
                            document.location.reload(true)
                        }, 1200)
                    } else {
                        msgErro('Falha ao enviar formulário!');
                    }
                });
            }
        }
   });

   //Anexar imagem blog comentário
   $("#anexar-imagem").change(function(){
      if ($("#anexar-imagem")[0].files && $("#anexar-imagem")[0].files[0]) {
         var filename = $(this).val();
         var reader = new FileReader();
         var extension = filename.replace(/^.*\./, '');
         if (extension == filename) { extension = '';
         }else{ extension = extension.toLowerCase(); }

         if(extension!='jpg' && extension!='png' && extension!='gif' && extension!='jpeg' ){
           msgErro('A extensão deste arquivo não é permitida!');
           $("#anexar-imagem").val('');
           return false;
         }

         var tamanhoMaximo ;
         tamanhoMaximo = ($("#maxFileSize").val())*1000000;
         if($(this)[0].files[0].size >  tamanhoMaximo){
             msgErro('Arquivo muito grande!');
             $("#anexar-imagem").val('');
             return false;
         }

         reader.onload = function(e) {
            $('#imagem-upload').attr('src', e.target.result);
            // $('#imagem-upload').css("display","block");
            // $('#imagem-upload').css("margin-bottom","15px");
            // $('#icone-comentario').css("display","none");
         }
         reader.readAsDataURL($("#anexar-imagem")[0].files[0]);
      }
   });
});

function checkVisible(elm) {
    var rect = elm.getBoundingClientRect();
    var viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
    return !(rect.bottom < 0 || rect.top - viewHeight >= 0);
}

function callbackCEP(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('endereco').value=(conteudo.logradouro);
        document.getElementById('bairro').value=(conteudo.bairro);
        document.getElementById('cidade').value=(conteudo.localidade);
        document.getElementById('uf').value=(conteudo.uf);
    } //end if.
    else {
        //CEP não Encontrado.
        $("#cep").addClass('border-error');
        msgErro('CEP não Encontrado.');
        Loader.hide();
    }
}

function pesquisaCEP(valor) {
    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('endereco').value="";
            document.getElementById('bairro').value="";
            document.getElementById('cidade').value="";
            document.getElementById('uf').value="";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=callbackCEP';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            return false;
        }
    } //end if.
    else {
        return false;
    }
}

function validarCPF(cpf) {  
    cpf = cpf.replace(/[^\d]+/g,'');    
    if(cpf == '') return false; 
    // Elimina CPFs invalidos conhecidos    
    if (cpf.length != 11 || 
        cpf == "00000000000" || 
        cpf == "11111111111" || 
        cpf == "22222222222" || 
        cpf == "33333333333" || 
        cpf == "44444444444" || 
        cpf == "55555555555" || 
        cpf == "66666666666" || 
        cpf == "77777777777" || 
        cpf == "88888888888" || 
        cpf == "99999999999")
            return false;       
    // Valida 1o digito 
    add = 0;    
    for (i=0; i < 9; i ++)      
        add += parseInt(cpf.charAt(i)) * (10 - i);  
        rev = 11 - (add % 11);  
        if (rev == 10 || rev == 11)     
            rev = 0;    
        if (rev != parseInt(cpf.charAt(9)))     
            return false;       
    // Valida 2o digito 
    add = 0;    
    for (i = 0; i < 10; i ++)       
        add += parseInt(cpf.charAt(i)) * (11 - i);  
    rev = 11 - (add % 11);  
    if (rev == 10 || rev == 11) 
        rev = 0;    
    if (rev != parseInt(cpf.charAt(10)))
        return false;       
    return true;   
}

function validarCNPJ(cnpj) {
 
    cnpj = cnpj.replace(/[^\d]+/g,'');
 
    if(cnpj == '') return false;
     
    if (cnpj.length != 14)
        return false;
 
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        return false;
         
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
           
    return true;
    
}

function enviarFormEmail(local, verificarEmail){
   var form = "form-"+local;
   var formData = new FormData($('#'+form)[0]);   
   var valida = validaForm({
      form: $("form#"+form),
      notValidate: true,
      validate: true
   });
   if(verificarEmail == true){
      var valida = validateEmail($("form#"+form+" input[name='email']").val());
   }else{
      var valida = true;
   }
   if(valida == false){
      msgErro('E-mail inválido');
      $("form#"+form+" input[name='email']").val('');
      $("form#"+form+" input[name='email']").addClass("border-error");
   }else{
      $("form#"+form+" input[name='email']").removeClass('border-error').addClass("border-complete");
      var valida = validaForm({
         form: $("form#"+form),
         notValidate: true,
         validate: true
      });
      if (valida) {
         $.ajax({
            url: 'admin/email_script.php?opx='+local,
            type: 'post',
            dataType : "json",
            data: formData,
            processData: false,
            contentType: false,
            // data: $("form#"+form).serialize(),
            beforeSend:function(){
               Loader.show();
            }
         }).done(function (e) {
            Loader.hide();
            if (e.status) {
               msgSucesso('Formulário enviado com sucesso!');
               $('#'+form)[0].reset();
            } else {
               msgErro('Falha ao enviar formulário!');
            }
         });
      }
   }
}
function validaForm(params)
{
    var valida = true;
    var notpermitidos = ['', '__/__/____', undefined, null];
    var config = {
        form    : $(params.form.selector),
        notValidate : false,
        msgError  : 'Preencha o(s) campo(s) obrigatório(s)',
        validate  : false,
        msgValidate :  'O formulário foi validado com sucesso.',
        validaEmail : false
    }
    $.extend(config, params);
    var $form = config.form;
    $form.find(':input.required', 'select.required').each(function () {
        var border = (!$(this).val()) ? 'border-error' : 'border-complete';
        if ($.inArray($(this).val(), notpermitidos) == 0){
            valida = false;
        }
        $(this).closest('input, textarea, select').removeClass('border-error').addClass(border);

        if($(this).attr("id") == "arquivo"){
            $("#area_files").addClass("border-error");
        }else{
            $("#area_files").removeClass('border-error').addClass("border-complete");
        }
    });
    if (config.notValidate && !valida){
        msgErro(config.msgError);
    }else{
        $form.find(':input.validate_email').each(function (){
            if(!validateEmail($(this).val()))
            {
                $(this).css('border', '1px solid red');
                config.msgError = "E-mail inválido, verifique";
                valida = false;
            };
        });
        if (config.notValidate && !valida)
            msgErro(config.msgError);
    }
    return valida;
}
function msgErro(msg, pagina) {
    Swal.fire({
        icon: 'error',
        title: 'Erro!',
        text: msg,
        confirmButtonColor: "#002d1c",
        didClose: (toast)=>{
            if (pagina) {
                if (pagina != "") {
                    if (pagina == "home")
                        location.href = jQuery("#_endereco").val();
                    else if (pagina == "location")
                        location.reload();
                    else
                        location.href = jQuery("#_endereco").val() + pagina;
                }
            }
        }
    })
}
function msgSucesso(msg, pagina) {
    Swal.fire({
        icon: 'success',
        title: 'SUCESSO!',
        text: msg,
        confirmButtonColor: "#002d1c",
        didClose: (toast)=>{
            if (pagina) {
                if (pagina != "") {
                    if (pagina == "home")
                        location.href = jQuery("#_endereco").val();
                    else if (pagina == "location")
                        location.reload();
                    else
                        location.href = jQuery("#_endereco").val() + pagina;
                }
            }
        }
    })
}

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

// Verifica se o elemento está na visível na tela
function elementInView(elem){
    return $(window).scrollTop() < $(elem).offset().top + $(elem).height() ;
}
// Usage example
// $(window).scroll(function(){
//     if (elementInView($('#your-element'))){
//         console.log('there it is, wooooohooooo!');
//     }
// });

/*-----------------------------------------
Loader
-----------------------------------------*/
const Loader = {
    show() {
        // Inicia o Loader
        document.querySelector('.loader').classList.add('active');
    },
    hide() {
        // Inicia o Loader
        document.querySelector('.loader').classList.remove('active');
    }
}

/*-----------------------------------------
LGPD
-----------------------------------------*/
// Adiciona a classe ao body
document.body.className = document.body.className + " js_enabled";

// Variaveis do modal.
var modalLGPD = document.querySelector('.lgpd-cookies');
var botaoContinuar = document.querySelector('.lgpd-botao.continuar');
var botaoSair = document.querySelector('.lgpd-botao.sair');


/* Verifica se o modal já foi visualizado 
** e não o mostra novamente */
function primeiroAcesso() {
    /**
     * Set cookie
     *
     * @param string name
     * @param string value
     * @param int days
     * @param string path
     * @see http://www.quirksmode.org/js/cookies.html
    */

    function createCookie(name, value, days, path) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = "; expires=" + date.toGMTString();
        } else var expires = "";
        document.cookie = name + "=" + value + expires + "; path=" + path;
    }

    /**
     * Read cookie
     * @param string name
     * @returns {*}
     * @see http://www.quirksmode.org/js/cookies.html
    */

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    // Clique no botão de continuar, fecha o modal e salva que já foi visualizado.
    botaoContinuar.addEventListener('click', function () {
        modalLGPD.style.display = 'none';
        createCookie('lgpd-PROJETO-visualizada', 'yes', cookieExpiry, cookiePath);
    });

    // Clique no botão de sair, limpa os cookies e retorna ao site acessado anteriormente.
    botaoSair.addEventListener('click', function () {
        modalLGPD.style.display = 'none';

        // Capta os cookies criados.
        var cookies = document.cookie.split("; ");

        // Deleta os cookies criados.
        for (var c = 0; c < cookies.length; c++) {
            var d = window.location.hostname.split(".");
            while (d.length > 0) {
                var cookieBase = encodeURIComponent(cookies[c].split(";")[0].split("=")[0]) +
                    '=; expires=Thu, 01-Jan-1970 00:00:01 GMT; domain=' + d.join('.') + ' ;path=';
                var p = location.pathname.split('/');
                document.cookie = cookieBase + '/';
                while (p.length > 0) {
                    document.cookie = cookieBase + p.join('/');
                    p.pop();
                };
                d.shift();
            }
        }

        createCookie('lgpd-PROJETO-visualizada', 'no', cookieExpiry, cookiePath);

        // Retona a página de navegação anterior.
        history.go(-1);
    });

    var cookieMessage = document.querySelector('.lgpd-cookies');

    if (cookieMessage == null) {
        return;
    }
    
    var cookie = readCookie('lgpd-PROJETO-visualizada');

    if (cookie != null && cookie == 'yes') {
        cookieMessage.style.display = 'none';
    } else {
        cookieMessage.style.display = 'flex';
    }

    // Configura / atualiza o cookie.
    var cookieExpiry = cookieMessage.getAttribute('data-cookie-expiry');
    if (cookieExpiry == null) {
        cookieExpiry = 60;
    }
    var cookiePath = cookieMessage.getAttribute('data-cookie-path');
    if (cookiePath == null) {
        cookiePath = "/";
    }
}

// Carrega o LGPD após a página carregar completamente.
window.onload = primeiroAcesso();