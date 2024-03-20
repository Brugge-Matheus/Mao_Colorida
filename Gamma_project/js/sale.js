//ADD NO CARRINHO
function adicionarOrcamento() {
  $("#idproduto").css("border", "1px solid #dbdbdb");
  if ($("#idproduto").length > 0 && $("#idproduto").val() == "") {
      msgErro("Selecione um modelo");
      $("#idproduto").css("border", "1px solid red").focus();
  } else if ($('#produto_qtd').val() == "" || $('#produto_qtd').val() <= 0) {
      msgErro("Informe uma quantidade valida");
  } else {
      $.ajax({
          url: "cliente/actions.php",
          dataType: "json",
          type: "post",
          data: {
              "qtde" : $('#produto_qtd').val(),
              "idproduto" : $('#idproduto').val(),
              "opx" : 'add',
          },
          success: function (data) {
              if (data.status == true) {
                  $('#produto_qtd').val(1);
                  msgSucesso("Produto adicionado com sucesso!", '');
                  // $(".semitem").hide();
                  // $(".comitem").show();
                  // total = data.total + " item";
                  // if (data.total > 1) {
                  //     total = data.total + " itens";
                  // }
                  document.querySelector("#cart-counter").dataset["cart"] = data.total;
                  // $("#count_itens_card").html(data.total);
              } else {
                  msgErro("Erro ao adicionar item ao orcamento. Tente novamente", '');
              }
          }
      });
  }
}

function remove($idproduto) {
  Loader.show();
  $.ajax({
      url: "cliente/actions.php",
      dataType: "json",
      type: "post",
      data: "opx=remover&idproduto=" + $idproduto,
      success: function (data) {
          Loader.hide();
          if (data.status == true) {
              // $("#count_itens_card").html(data.total);
              //set_totais(response);
              console.log(data);
              location.reload();
          } else {
              msgErro("Erro ao remover item do orcamento. Tente novamente");
          }
      }
  });
}

function atualizaQtd(el, $idproduto) {

  if( parseInt($(el).val()) != parseInt($(el).attr('data-qtde')))
  {

      $("#valor_" + $idproduto + "_total").html( (parseFloat( $(el).attr('data-valor') ) * parseInt( $(el).val() )).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}) );
      $(".dados-do-orcamento").hide();
      $('#bt_atualizar').show();
      $.ajax({
          url: "cliente/actions.php",
          dataType: "json",
          type: "POST",
          data: "opx=atualizaQtd&idproduto=" + $idproduto + "&qtde=" + $(el).val(),
          success: function (data) {
              if (data.status == true) {
                  set_totais(response);
                  $("#count_itens_card").html(data.total);
                  
                  // location.reload();
              } else {
                  msgErro(data.msg);
              }
          }
      });
  };
}

function atualizar(el, $idproduto) {

  location.reload();
};

function total_orcamento() {
  Loader.show();
  $.ajax({
      url: "cliente/actions.php",
      dataType: "json",
      type: "POST",
      data: "opx=calcularTotal",
      success: function (response) {
          Loader.hide();
          if (response.status) {
              set_totais(response);
          } else {
              msgErro(response.message);
          }
      }
  });
}

function set_totais($sale)
{
  // console.log($totais);
  $("#subtotal").html( (new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(parseFloat($sale.totais.subtotal) )));
  $("#cashback").html( (new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(parseFloat($sale.totais.cashback) )));
  $("#desconto").html( (new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(parseFloat($sale.totais.desconto) )));
  $("#total").html( (new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(parseFloat($sale.totais.total) )));
  if(parseFloat($sale.totais.desconto)!=0) {
      $("#desconto").parent().removeClass("semdesconto");
  }else{
      $("#desconto").parent().addClass("semdesconto");
  };

  if( $sale.remove_frete )
  {
      $(".frete-resumo-inputs").html('').parent().addClass("semdesconto");
  };
}

function modalidade_frete( $codigo_modalidade_frete ) {
  Loader.show();
  $.ajax({
      url: "cliente/actions.php",
      dataType: "json",
      type: "POST",
      data: "opx=modalidadeFrete&codigo_modalidade_frete="+$codigo_modalidade_frete,
      success: function (response) {
          Loader.hide();
          if (response.status) {
              set_totais(response);
          } else {
              msgErro(response.message);
          }
      }
  });
}

function validar_voucher() {

  var cupom = $('#cupom').val();
  Loader.show();
  $.ajax({
      url: "cliente/actions.php",
      dataType: "json",
      type: "POST",
      data: {
          opx: "validarVoucher",
          cupom: cupom,
      },
      success: function(response){
          Loader.hide();
          if (response.status) {
              set_totais(response);
          } else {
              msgErro(response.message);
          };
      }
  });
}

let $cotacoes;
function calcular_frete_correios() {

  $('.frete-resumo').addClass('semdesconto');
  $('.frete-resumo-inputs').html('');
  Loader.show();
  $.ajax({
      url: "cliente/actions.php?opx=FreteCorreios",
      dataType: "json",
      type: "POST",
      data: {
          cep : $('input.cep').val(),
      },
      success: function (data) {
          Loader.hide();
          if (data.status == true) {
              $('.frete-resumo').removeClass('semdesconto');
              $.each( data.cotacoes, function( $code, $cotacao){
                  $(".frete-resumo-inputs").append(
                      `<label class="frete-option">
                      <input onclick="modalidade_frete('`+$code+`')" type="radio" name="frete" class="option-frete" value="`+$code+`" data-deadline="`+$cotacao.deadline+`" data-price="`+$cotacao.price+`" data-title="`+$cotacao.title+`" >
                      <span class="checkmark"></span>
                      <h4> `+$cotacao.title+( $cotacao.price!=0 ? `<span> `+(new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format($cotacao.price))+`</span>` : `` )+
                      ($cotacao.deadline!='' ? `<br><span style="font-size: 16px;font-weight: 400;"> (`+$cotacao.deadline+`)</span>` : '')+`</h4>
                      </label>`
                  );
              });                
          }
          else
          {
              msgErro(data.message);
          };            
      }
  });
}

function finish_sale ()
{
  var destinatario = $('#destinatario').val();
  var cpf = $('#cpf').val();
  var telefone = $('#telefone').val();
  var nm_residencia = $('#nm_residencia').val();
  var end_principal = $('#end_principal').val();
  var complemento = $('#complemento').val();

  var nm_cartao =  $("#card_criptografado").val(); // "000000000000000000";//$('#nm_cartao').val();
  var nome_cartao = $('#nome_cartao').val();
  var dt_expedicao_cartao = $('#dt_expedicao_cartao').val();
  var cvv = $('#cvv').val();

  //Verifica se há campos em branco
  var campos = { destinatario: destinatario, cpf: cpf, telefone: telefone, nm_residencia: nm_residencia, complemento: complemento};

  var valida = true;
  $.each(campos, function(index, value){
      if(value == ''){  
          $('#'+index).css({'border': 'solid 1px red'});
          valida = false;
      }else{
          $('#'+index).css({'border': '2px solid #d7d7d7'});
          
      }
  });

  if(valida == false)
  {
      msgErro('Por favor, Preencha os campos obrigatórios');
      return false;
  };

  if($('#payment_method').val() == '')
  {
      msgErro('Por favor, selecione uma forma de pagamento');
      return false;
  };

  if($('#payment_method').val() == 'CARD_CREDIT')
  {
      var $card_cript =  cript_card();

      if( !$card_cript ){
          msgErro('Por favor, verifique os dados de seu cartão de crédito');
          return false;
      };

      $send = {
          payment_method: 'CARD_CREDIT',
          responsavel: destinatario,
          cpf: cpf,
          contato: telefone,
          numero: nm_residencia,
          complemento: complemento,
          principal: end_principal,
          nm_cartao: nm_cartao,
          nome_cartao: nome_cartao,
          dt_expedicao_cartao: dt_expedicao_cartao,
          cvv: cvv,
          card_cript: $("#card_criptografado").val(),
          parcelas: $("#parcelas").val(),
      };
  };

  if($('#payment_method').val() == 'BOLETO')
  {
      $send = {
          payment_method: 'BOLETO',
          parcelas: 1,
          responsavel: destinatario,
          cpf: cpf,
          contato: telefone,
          numero: nm_residencia,
          complemento: complemento,
          principal: end_principal
      };
  };

  if($('#payment_method').val() == 'PIX')
  {
      $send = {
          payment_method: 'PIX',
          parcelas: 1,
          responsavel: destinatario,
          cpf: cpf,
          contato: telefone,
          numero: nm_residencia,
          complemento: complemento,
          principal: end_principal,
      };
  };

  Loader.show();

  $.ajax({
      url: 'cliente/integracoes/pagamento-pagseguro.php',
      dataType: 'json',
      type: 'post',
      data: $send,
          success: function(response){
              Loader.hide();
              if( response.status ){
                      window.location.href = './finished';
              }else{
                  if(response.code == 1)
                  {
                      msgErro(response.message);
                      window.setTimeout( function(){ window.location.href = './login';}, 3000);
                  }else if(response.code == 2)
                  {
                      msgErro(response.message);
                      window.setTimeout( function(){ window.location.href = './orcamento';}, 3000);
                  }else if(response.code == 12)
                  {
                      msgErro(response.message);
                      window.setTimeout( function(){ window.location.href = './minha-conta';}, 3000);
                  } else {
                      msgErro(response.message);
                  };
              };                
          },
  });
};


$(document).ready(function(){

  $('#valida_cupom').on('click', function(e){
      e.preventDefault();
      validar_voucher();
  });

  $('#encerrar_pedido').on('click', e=>{
      e.preventDefault();
      finish_sale();
  });

  $('#frete').on('click', e=>{
      e.preventDefault();
      calcular_frete_correios();
  });

  //Botao de finalizar compra
  $('#finalizar').on('click', e=>{
      e.preventDefault();
      Loader.show();
      $.ajax({
          url: 'cliente/actions.php?opx=CadastrarPedido',
          dataType: 'json',
          type: 'post',
          data: { },
          success: response=>{
              Loader.hide();
              if( response.status ){
                  window.location = 'checkout';
              }else{
                  msgErro(response.message);
              };                
          },
          error: response=>{
              msgErro( response.message);
          }
      });
  });

  //Redirecionar usuario para login caso nao esteja logado
  $('#logar_user').on('click', ()=>{
      window.location = 'login';
  });


});





//   function buscaFrete(largura, altura, comprimento, cep, preco, peso, op_frete) {
//       Loader.show();
    
//       if($('.opc_traspo:checked').length > 0 && $('.opc_traspo:checked').length < 2){
//         $('.opc_traspo:checked').attr('data-checked','false');
//         var valorChecked = parseFloat($('.opc_traspo:checked').attr('data-valor'));
//         var valorTotal = parseFloat($("#valor_total").text().replace(',','.'));
//         var novoValor = valorChecked - valorTotal;
//         $("#valor_total").text(Math.abs(novoValor).toLocaleString('pt-BR',{minimumFractionDigits: 2, maximumFractionDigits: 2}));
//         $('.opc_traspo:checked').removeAttr('checked');
//       }

//       var tipo = "04510";

//       if ($('#pagina').val() == 'endereco') {
//         var pagina = "endereco";
//       }
//       else{
//         var pagina = "";
//       }

//       $.ajax({
//           url: 'includes/calculaFrete.php',
//           type: 'post',
//           dataType: 'json',
//           async: false,
//           cache: false,
//           data: {
//               largura: largura,
//               altura: altura,
//               comprimento: comprimento,
//               cep: cep,
//               tipo: tipo,
//               preco: preco,
//               peso: peso,
//               ajax: true
//           },

//       })
//           .done(function (data) {
//               if (data.dados.status && data.dados.valor != 0) {
//                   valor = data.dados.valor + '';
//                   if (valor.indexOf('.') == -1) {
//                       valor = valor + ',00';
//                   } else {
//                       valor = valor.replace('.', ',');
//                       v1 = valor.split(",");
//                       switch (v1[1]) {
//                           case '1':
//                           case '2':
//                           case '3':
//                           case '4':
//                           case '5':
//                           case '6':
//                           case '7':
//                           case '8':
//                           case '9':
//                           case '0':
//                               valor = valor + "0";
//                               break;

//                       }
//                   }
//                   if ($('#pagina').val() == 'endereco') {
//                       $('.frete-disponivel').each(function () {
//                           $(this).css('display', 'none');
//                           if ($(this).data('op_frete') == op_frete) {
//                               $(this).css('display', 'block');
//                               $(this).find(".op_pac").css('display', 'block');
//                               $(this).find('.frete_pac').html("R$ " + valor);
//                               $(this).find('.opc_pac').attr('data-valor', valor.replace(',', '.'));
//                               $(this).find('.mensagem_pac').html("Chegará de " + data.dados.prazo + " à " + (parseInt(data.dados.prazo) + 2) + " dias úteis");
//                               $(this).find('.mensagem_pac').data("prazo", data.dados.prazo);
//                           }
//                       });
//                   } else {
//                       $(".op_frete").css('display', 'block');
//                       $(".op_pac").css('display', 'block');
//                       $('.frete_pac').html("R$ " + valor);
//                       $('.opc_pac').attr('data-valor', valor.replace(',', '.'));
//                       $('.mensagem_pac').html("Chegará de " + data.dados.prazo + " à " + (parseInt(data.dados.prazo) + 2) + " dias úteis");
//                       $('.mensagem_pac').data("prazo", data.dados.prazo);
//                   }
//               } else if(data.dados.status == false) {
//                   $(".op_pac").css('display', 'none');
//                   msgErro(data.dados.erro);
//               }
//           });

//       tipo = "04014";
//       $.ajax({
//           url: 'includes/calculaFrete.php',
//           type: 'post',
//           dataType: 'json',
//           async: false,
//           data: {
//               largura: largura,
//               altura: altura,
//               comprimento: comprimento,
//               cep: cep,
//               tipo: tipo,
//               preco: preco,
//               peso: peso,
//               ajax: true
//           },
//       })
//           .done(function (data) {
//               if (data.dados.status && data.dados.valor != 0) {
//                   valor = data.dados.valor + '';
//                   if (valor.indexOf('.') == -1) {
//                       valor = valor + ',00';
//                   } else {
//                       valor = valor.replace('.', ',');
//                       v1 = valor.split(",");
//                       switch (v1[1]) {
//                           case '1':
//                           case '2':
//                           case '3':
//                           case '4':
//                           case '5':
//                           case '6':
//                           case '7':
//                           case '8':
//                           case '9':
//                           case '0':
//                               valor = valor + "0";
//                               break;

//                       }
//                   }
//                   if ($('#pagina').val() == 'endereco') {
//                       $('.frete-disponivel').each(function () {
//                           if ($(this).data('op_frete') == op_frete) {
//                               $(this).find(".op_frete").css('display', 'block');
//                               $(this).find(".op_sedex").css('display', 'block');
//                               $(this).find('.frete_sedex').html("R$ " + valor);
//                               $(this).find('.opc_sedex').attr('data-valor', valor.replace(',', '.'));
//                               $(this).find('.mensagem_sedex').html("Chegará de " + data.dados.prazo + " à " + (parseInt(data.dados.prazo) + 2) + " dias úteis");
//                               $(this).find('.mensagem_sedex').data("prazo", data.dados.prazo);
//                           }
//                       });
//                   } else {
//                       $(".op_frete").css('display', 'block');
//                       $(".op_sedex").css('display', 'block');
//                       $('.frete_sedex').html("R$ " + valor);
//                       $('.opc_sedex').attr('data-valor', valor.replace(',', '.'));
//                       $('.mensagem_sedex').html("Chegará de " + data.dados.prazo + " à " + (parseInt(data.dados.prazo) + 2) + " dias úteis");
//                       $('.mensagem_sedex').data("prazo", data.dados.prazo);
//                   }
//               } 
//               else if(data.dados.status == false) {
//                   $(".op_sedex").css('display', 'none');
//                   msgErro(data.dados.erro);
//               }
//           });
    
//       // $.ajax({
//       //     url: 'admin/transportadora_script.php',
//       //     type: 'post',
//       //     dataType: 'json',
//       //     data: {
//       //         cep: cep,
//       //         peso: peso,
//       //         ajax: true,
//       //         opx: 'buscaFrete',
//       //         pagina: pagina,
//       //         ajax: true
//       //     },
//       // })
//       //     .done(function (data) {
//       //         if (data.dados.status) {
//       //             valor = data.dados.valor + '';
//       //             if (valor.indexOf('.') == -1) {
//       //                 valor = valor + ',00';
//       //             } else {
//       //                 valor = valor.replace('.', ',');
//       //                 v1 = valor.split(",");
//       //                 switch (v1[1]) {
//       //                     case '1':
//       //                     case '2':
//       //                     case '3':
//       //                     case '4':
//       //                     case '5':
//       //                     case '6':
//       //                     case '7':
//       //                     case '8':
//       //                     case '9':
//       //                     case '0':
//       //                         valor = valor + "0";
//       //                         break;

//       //                 }
//       //             }
//       //             if ($('#pagina').val() == 'endereco') {
//       //                 $('.frete-disponivel').each(function () {
//       //                     if ($(this).data('op_frete') == op_frete) {
//       //                         $(this).css('display', 'block');
//       //                         // $(this).find("#op_frete").css('display', 'block');
//       //                         $(this).find(".op_transp").css('display', 'block');
//       //                         $(this).find('.frete_traspo').html("R$ " + valor);
//       //                         $(this).find('.opc_traspo').attr('data-valor', valor.replace(',', '.'));
//       //                         $(this).find('.mensagem_traspo').html("Chegará de " + data.dados.prazo + " à " + (parseInt(data.dados.prazo) + 2) + " dias úteis");
//       //                         $(this).find('.mensagem_traspo').data("prazo", data.dados.prazo);
//       //                     }
//       //                 });
//       //             } else {
//       //                 $(".op_frete").css('display', 'block');
//       //                 $(".op_transp").css('display', 'block');
//       //                 $('.frete_traspo').html("R$ " + valor);
//       //                 $('.opc_traspo').attr('data-valor', valor.replace(',', '.'));
//       //                 $('.mensagem_traspo').html("Chegará de " + data.dados.prazo + " à " + (parseInt(data.dados.prazo) + 2) + " dias úteis");
//       //                 $('.mensagem_traspo').data("prazo", data.dados.prazo);
//       //             }
//       //         } else {
//       //             $(".op_transp").css('display', 'none');
//       //             msgErro("Não entregamos para este cep.");
//       //         }
//       //     });

//       Loader.hide();

//   }


//   //CALCULAR FRETE

//       if($('.cep').val() == ''){
//           return false;
//       }
//       e.preventDefault();
//       var altura = $('#altura').val();
//       var comprimento = $('#comprimento').val();
//       var largura = $('#largura').val();
//       var peso = $('#peso').val();
//       var preco = $('#preco').val();
//       var cep = $('.cep').val();
//       var qtde = $('#qtde').val();


//       if((peso)>=60){
//           alert('Peso Maximo para entrega: 60kg');
//           exit;
//       }
    
//       $.ajax({
//               url: "includes/calculaFrete.php?opx=pac",
//               dataType: "html",
//               type: "post",
//               data: {
//                   altura: altura,
//                   comprimento: comprimento,
//                   largura: largura,
//                   peso: peso,
//                   preco: preco,
//                   qtde: qtde,
//                   cep: cep,
//               },
//               beforeSend: ()=>{
//                   Loader.show();
//               },
//               success: function(data){
//                   Loader.hide();
//                   $('#campofrete').removeClass('semdesconto');
//                   $('#checksedex').removeClass('checkmark');
//                   $('#checkpac').removeClass('checkmark');
//                   if(data == 0){
//                       $('#nrm').html(' Frete Grátis');
//                   }else{
//                       $('#nrm').html('PAC R$ '+data);
//                   }
//                   $('#nrm').attr('data-id',data)
//                   $('#frete-pac').attr('data-id',data);
//               }
//           })

//       $.ajax({
//               url: "includes/calculaFrete.php?opx=sedex",
//               dataType: "html",
//               type: "post",
//               data: {
//                   altura: altura,
//                   comprimento: comprimento,
//                   largura: largura,
//                   peso: peso,
//                   preco: preco,
//                   qtde: qtde,
//                   cep: cep,
//               },beforeSend: ()=>{
//                   Loader.show();
//               },
//               success: function(data){
//                   Loader.hide();
//                   if(data != 0){
//                       $('#campofrete').removeClass('semdesconto');
//                       $('#checksedex').removeClass('checkmark');
//                       $('#checkpac').removeClass('checkmark');
//                       if(data == 0){
//                           $('#exp').html(' Frete Grátis');
//                       }else{
//                           $('#exp').html('SEDEX R$ '+data);
//                       }
//                       $('#frete-exp').attr('data-id',data)
//                       $('#exp').attr('data-id',data)
//                       $('#sedex').attr('value',data)
//                   }else{
//                       $('#exp').html('');
//                   }
//               }
//           })

//   })

//   //Validar Cupom



//   //Calculo do total da compra + frete
//   $('.frete').on('click', e=>{
//       click = true;
//       //$('#subtotal2').attr('value', total_inicial);
//       frete = $(e.target).data('id');
//       var check1 = $(e.target).attr('id');
//       if(check1 == 'frete-pac' || check1 == 'nrm'){
//           $('#inpsedex').attr('checked', 'checked')
//           $('#checksedex').removeClass('checkmark');
//           $('#checkpac').addClass('checkmark');
//       }
//       if(check1 == 'frete-exp' || check1 == 'exp'){
//           $('#inppac').attr('checked', 'checked')
//           $('#checksedex').addClass('checkmark');
//           $('#checkpac').removeClass('checkmark');
//       }
//       frete = frete.toString().split(",");
//       frete = parseFloat(frete.join('.'))
//       var subtotal = parseFloat($('#subtotal2').val());
//       var total_compra = parseFloat(frete) + parseFloat(subtotal);
//       $('.total2').html('R$ '+ total_compra.toFixed(2));
//       $('#subtotal2').attr('value', total_compra);
//       total_inicial = total_compra - frete;
//       $('.frete').off('click')
//   });