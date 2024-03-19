// Versao do modulo: 3.00.010416

var preventCache = Math.random();
var requestInicio = "";
var ordem = "";
var dir = "";
var pesquisar = "";
var limit = 20;
var pagina = 0;
var totalPaginasGrid = 1;

function preTableProduto() {
    $("#limit").change(function () {
        $("#pagina").val(1);
        dataTableProduto();
    });

    $("#pagina").keyup(function (e) {
        if (e.keyCode == 13) {
            if (totalPaginasGrid >= $(this).val() && $(this).val() > 0) {
                dataTableProduto();
            } else {
                msgErro("numero de pagina deve ser entre 1 e " + totalPaginasGrid);
            }
        }
    });

    $(".next").click(function (e) {
        e.preventDefault();
        $("#pagina").val($(this).attr('proximo'));
        dataTableProduto();
    });

    $(".prev").click(function (e) {
        e.preventDefault();
        $("#pagina").val($(this).attr('anterior'));
        dataTableProduto();
    });


    //LISTAGEM BUSCA
    $("#buscarapida").keyup(function (event) {
        event.preventDefault();
        if (event.keyCode == '13') {
            pesquisar = "&nome=" + $("#buscarapida").val();
            dataTableProduto();
        }
        return true;
    });

    $("#filtrar").click(function (e) {
        e.preventDefault();
        pesquisar = "&" + $("#formAvancado").serialize();
        dataTableProduto();
    });

    $(".ordem").click(function (e) {
        e.preventDefault();
        ordem = $(this).attr("ordem");
        dir = $(this).attr("order");
        $(".ordem").removeClass("action");
        $(".ordem").removeClass("actionUp");
        if ($(this).attr("order") == "asc") {
            $(this).attr("order", "desc");
            $(this).removeClass("action");
            $(this).addClass("actionUp");
        } else {
            $(this).attr("order", "asc");
            $(this).removeClass("actionUp");
            $(this).addClass("action");
        }
        dataTableProduto();
    });

    $('.table').on("click", ".inverteStatus", function (e) {
        var params = {
           idproduto: $(this).attr("codigo")
        }
  
        $.post(
           'produto_script.php?opx=inverteStatus',
           params,
           function (data) {
              var resultado = new String(data.status);
  
              if (resultado.toString() == 'sucesso') {
                 dataTableProduto();
              }
              else if (resultado == 'falha') {
                 alert('Não foi possível atender a sua solicitação.')
              }
  
           }, 'json'
        );
     });

}

var myColumnDefs = [
    {key: "idproduto", sortable: true, label: "ID Produto", print: true, data: true},
    {key: "nome", sortable: true, label: "Nome", print: true, data: true},
    // {key: "codigo", sortable: true, label: "Codigo", print: true, data: true},
    // {key: "valor", sortable: true, label: "Preço", print: true, data: false},
    // {key: "_valor", sortable: false, label: "Preço", print: false, data: true},
    {key: "urlrewrite", sortable: true, label: "Urlrewrite", print: true, data: false},
    // {key: "destaque", sortable: true, label: "Destaque", print: false, data: false},
    // {key: "imagem", sortable: true, label: "Imagem", print: false, data: false},
    {key: "informacoes", sortable: true, label: "Resumo", print: true, data: false},
    // {key: "resumo_tecnico", sortable: true, label: "Resumo_tecnico", print: false, data: false},
    {key: "descricao", sortable: true, label: "Descrição", print: true, data: false},
    {key: "title", sortable: true, label: "Title", print: true, data: false},
    {key: "description", sortable: true, label: "Description", print: true, data: false},
    {key: "keywords", sortable: true, label: "Keywords", print: true, data: false},
    {key: "status", sortable: true, label: "Status", print: true, data: false},
    {key: "status_icone", sortable: false, label: "Status", print: false, data: true}
]

function columnProduto() {
    tr = "";
    $.each(myColumnDefs, function (col, ColumnDefs) {
        if (ColumnDefs['data']) {
            orderAction = "";
            ordena = "";
            if (ColumnDefs['key'] == ordem) {
                if (dir == "desc") {
                    orderAction = "actionUp";
                } else {
                    orderAction = "action";
                }
            }
            if (ColumnDefs['sortable']) {
                ordena = 'ordem="' + ColumnDefs['key'] + '" class="ordem ' + orderAction + '" order="' + dir + '"';
            }
            tr += '<th><a href="#" ' + ordena + '>' + ColumnDefs['label'] + '</a></th>';
        }
    });
    tr += "<th></th>";
    $('#listagem').find("thead").append(tr);
}

function dataTableProduto() {
    limit = $("#limit").val();
    pagina = $("#pagina").val();
    pagina = parseInt(pagina) - 1;
    colunas = myColumnDefs;
    colunas = JSON.stringify(colunas);
    queryDataTable = requestInicio + "&ordem=" + ordem + pesquisar + "&dir=" + dir + "&colunas=" + colunas;
    $.ajax({
        url: "base_proxy.php",
        dataType: "json",
        type: "post",
        data: requestInicio + "&limit=" + limit + "&pagina=" + pagina + "&ordem=" + ordem + pesquisar + "&dir=" + dir,
        beforeSend: function () {
            $.fancybox.showLoading();
            $('#listagem').find("tbody tr").remove();
        },
        success: function (data) {
            tr = "";
            if (data.totalRecords > 0) {
                $.each(data.records, function (index, value) {
                    tr += '<tr>';
                    $.each(myColumnDefs, function (col, ColumnDefs) {
                        if (ColumnDefs['data']) {
                            key = ColumnDefs['key'];
                            tr += '<td><span>' + value[key] + '</span></td>';
                        }
                    });

                    tr += '<td><div class="acts">';
                    tr += '<a href="index.php?mod=produto&acao=formProduto&met=editProduto&idu=' + value.idproduto + '"><img src="images/ico_edit.png" height="16" width="16" alt="ico" /><div class="tt"><span class="one">Editar</span><span class="two"></span></div></a>';
                    tr += '<a href="#" onclick="wConfirm(\'Excluir Registro\',\'Tem certeza que deseja excluir o registro ' + value.nome + ' ?\',\'php\', \'produto_script.php?opx=deletaProduto&idu=' + value.idproduto + '\');"><img src="images/ico_del.png" height="17" width="17" alt="ico" /><div class="tt"><span class="one">Excluir</span><span class="two"></span></div></a>';
                    tr += '</div></td>';
                });
                $('#listagem').find("tbody").append(tr);
                atualizaPaginas(data.pageSize, (pagina + 1), data.totalRecords);
                $('.pagination').show();
            } else {
                $('#listagem').find("tbody").append('<tr class="odd pesquisa_error"><td colspan="' + myColumnDefs.length + '">Nenhum resultado encontrado</td></tr>');
                $('.pagination').hide();
            }
        },
        complete: function () {
            $.fancybox.hideLoading();
        }
    });
}

function addGrid(nome, uploadImagem = true, nomeInput1 = "nome", nomeInput2 = "descricao", width = 50, height = 50){
    
    var novoinput = '';

    var nomeCapitalized = nome.charAt(0).toUpperCase() + nome.slice(1);
    novoinput += '<tr class="box-'+nome+' remove'+nomeCapitalized+'-'+$('.box-'+nome).length+'" data-key="'+$('.box-'+nome).length+'">';

    if(uploadImagem == true){
        novoinput += '<td align="center" class="td-padding">';
        novoinput += '<img src="https://via.placeholder.com/50?text=Upload+Foto" width="50" class="img-upload img-'+$('.box-'+nome).length+'" data-key="'+$('.box-'+nome).length+'" />';
        novoinput += '<input type="file" name="'+nome+'['+$('.box-'+nome).length+'][imagem]" class="file-upload upload-'+$('.box-'+nome).length+'" data-key="'+$('.box-'+nome).length+'">';
        novoinput += '<span class="fs-11">Tamanho recomendado '+width+'x'+height+'px'+' </span>';
        novoinput += '<br/><span><b>OU</b></span>';
        novoinput += '<div id="mostrar_icone_'+nome+'-'+$('.box-'+nome).length+'" class="m-15">';
        novoinput += '<i id="current-icon-'+nome+'-'+$('.box-'+nome).length+'" data-grid="'+nome+'"  class="current-icon fas fa- fa-2x"></i>';
        novoinput += '</div>';
        novoinput += '<input type="button" value="Escolher ícone" data-grid="'+nome+'" class="btn-choose-icon button-escolher-icone btn button-escolher-icone-'+nome+'" data-key="'+$('.box-'+nome).length+'">';
        novoinput += '<input type="hidden" name="'+nome+'['+$('.box-'+nome).length+'][imagem]" value="">';
        novoinput += '<input type="hidden" name="'+nome+'['+$('.box-'+nome).length+'][icone]" value="" id="imagem_icone-'+nome+'-'+$('.box-'+nome).length+'">';
        novoinput += '<input type="hidden" name="'+nome+'['+$('.box-'+nome).length+'][nome_icone]" value="" id="nome_icone-'+nome+'-'+$('.box-'+nome).length+'">';
        novoinput += '</td>';
    }

    novoinput += '<td colspan="2">';
    novoinput += '<input type="hidden" name="'+nome+'['+$('.box-'+nome).length+'][id'+nome+']" value="0">';
    novoinput += '<input id="excluir'+nomeCapitalized+'-'+$('.box-'+nome).length+'" type="hidden" name="'+nome+'['+$('.box-'+nome).length+'][excluir'+nomeCapitalized+']" value="1">';
    novoinput += '<input type="text" class="box_txt input'+nomeCapitalized+' w-100" name="'+nome+'['+$('.box-'+nome).length+']['+nomeInput1+']" placeholder="Pergunta">';
    novoinput += '<textarea rows="6" type="text" style="resize: vertical" class="box_txt input'+nomeCapitalized+' w-100" name="'+nome+'['+$('.box-'+nome).length+']['+nomeInput2+']" placeholder="Resposta"></textarea>';
    novoinput += '</td>';

    novoinput += '<td align="center">';
    novoinput += '<span class="td-flex">'
    novoinput += '<span class="subir'+nomeCapitalized+'" data-key="'+$('.box-'+nome).length+'">'
    novoinput += '<b class="fas fa-arrow-up"></b>'
    novoinput += '</span>'
    novoinput += '<span class="descer'+nomeCapitalized+'" data-key="'+$('.box-'+nome).length+'">'
    novoinput += '<b class="fas fa-arrow-down"></b>'
    novoinput += '</span>'
    novoinput += '<span class="excluir'+nomeCapitalized+'" data-key="'+$('.box-'+nome).length+'">'
    novoinput += '<b class="fas fa-trash"></b>'
    novoinput += '</span>'
    novoinput += '<input type="hidden" name="'+nome+'['+$('.box-'+nome).length+'][ordem]" value="'+$('.box-'+nome).length+'">';
    novoinput += '</span>'
    novoinput += '</td>';
    novoinput += '</tr>';

    novoinput += '<tr class="remove'+nomeCapitalized+'-'+$('.box-'+nome).length+'">';
    novoinput += '<td colspan="4">';
    novoinput += '<div style="padding: 0 0 0 10px; width: 100%" data-grid="'+nome+'" data-key="'+$('.box-'+nome).length+'" class="div-show-icons box_ip div-icones" style="width: 100% !important;"></div>';
    novoinput += '</td>';
    novoinput += '</tr>';

    $('.'+nome).append(novoinput);

    addActionFaq();
}

function subirFaq ( el ) {
    var thisDataKey = $(el).parent().parent().parent().attr('data-key');
    var auxDiv = $('.div-aux');
    var thisTr = $(el).parent().parent().parent();
    var prevTr = $(thisTr).prevAll('.box-produto_faq').first();
    var thisInputPos = $(thisTr).find('.td-flex').find('input');
    var prevInputPos = $(prevTr).find('.td-flex').find('input');
    var auxInputPos = $(thisInputPos).val();
    if($(prevTr).length > 0){
        $(thisInputPos).val($(prevInputPos).val());
        $(prevInputPos).val(auxInputPos);
        $(thisTr).children().appendTo(auxDiv);
        $(prevTr).children().appendTo(thisTr);
        $(auxDiv).children().appendTo(prevTr);
    }
};

function descerFaq( el ) {
    var thisDataKey = $(el).parent().parent().parent().attr('data-key');
    var auxDiv = $('.div-aux');
    var thisTr = $(el).parent().parent().parent();
    var nextTr = $(thisTr).nextAll('.box-produto_faq').first();
    var thisInputPos = $(thisTr).find('.td-flex').find('input');
    var nextInputPos = $(nextTr).find('.td-flex').find('input');
    var auxInputPos = $(thisInputPos).val();
    if($(nextTr).length > 0){
        $(thisInputPos).val($(nextInputPos).val());
        $(nextInputPos).val(auxInputPos);
        $(thisTr).children().appendTo(auxDiv);
        $(nextTr).children().appendTo(thisTr);
        $(auxDiv).children().appendTo(nextTr);
    }
};

function excluirFaq (el) {
    var key = $(el).parent().parent().parent().attr('data-key');
    $('.removeProduto_faq-'+key).hide();
    // $('.removeFaq-'+key).next('tr').remove();
    $('#excluirProduto_faq-'+key).val('0');
    // $('.removeFaq-'+key).remove();
};

function addActionFaq() {
    $(".subirProduto_faq").unbind( "click" );
    $(".descerProduto_faq").unbind( "click" );
    $(".excluirProduto_faq").unbind( "click" );

    $(".subirProduto_faq").on("click", function () {
        subirFaq($(this));
    });

    $(".descerProduto_faq").on("click", function () {
        descerFaq($(this));
    });

    $(".excluirProduto_faq").on("click", function () {
        excluirFaq($(this));
    });
}

$(document).ready(function () {

    select = $(".listCategorias .categorias").last().find("select[name='idcategoria[]']");
    selectSub = $(".listCategorias .categorias").last().find("select[name='idsubcategoria[]']");

    if ($(select).find("option").length == 2 && $(selectSub).find("option").length == 2) {
        $(".maisCategoria").hide();
    }

    //===== Grid FAq =====//

    $(".btn-produto_faq").on('click', function () {
        addGrid('produto_faq', false, "pergunta", "resposta");
    });

    addActionFaq();
    

    // ================== fim faq

    //FAZ O UPLOAD DA IMAGEM
    $(".foto").change(function () {
        var filename = $(this).val();
        // Use a regular expression to trim everything before final dot
        var extension = filename.replace(/^.*\./, '');
        // Iff there is no dot anywhere in filename, we would have extension == filename,
        // so we account for this possibility now
        if (extension == filename) {
            extension = '';
        } else {
            // if there is an extension, we convert to lower case
            // (N.B. this conversion will not effect the value of the extension
            // on the file upload.)
            extension = extension.toLowerCase();
        }

        if (extension != 'jpg' && extension != 'png' && extension != 'gif' && extension != 'jpeg') {
            msgErro('A extensão deste arquivo não é permitida!');
            return false;
        }

        var tamanhoMaximo;
        tamanhoMaximo = ($("#maxFileSize").val()) * 1000000;
        if ($(this)[0].files[0].size > tamanhoMaximo) {
            msgErro('Arquivo muito grande!');
            return false;
        }

        //início AJAX
        var formData = new FormData();
        formData.append('imagem', this.files[0]);
        formData.append('opx', 'salvaImagem');

        formData.append('idproduto', $("#idproduto").val());
        $.ajax({
            url: "produto_script.php",
            type: "POST",
            dataType: "json",
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            beforeSend: function () {
                $.fancybox.showLoading();
            },
            success: function (data) {
                if (data.status == true) {
                    msgSucesso('Imagem enviada com sucesso.', '');
                    $('.imagem_grande').attr('src', data.caminho);
                    $('.imagem_grande').show();
                    $('#imagem').val(data.nome_arquivo);
                    $("#idproduto").val(data.idproduto);
                } else {
                    msgErro(data.msg);
                }
                $.fancybox.hideLoading();
            },
            complete: function () {
                $.fancybox.hideLoading();
            }
        });
    });

    $(".cancelar").click(function (event) {
        event.preventDefault();

        if ($("#mod").val() == 'cadastro') {
            $.ajax({
                url: 'produto_script.php',
                dataType: 'json',
                data: "opx=deletaCadastroTemporario&idtemporario=" + $("#idproduto").val(),
                type: 'post',
                beforeSend: function () {
                    $.fancybox.showLoading();
                },
                success: function (data) {
                    location.href = 'index.php?mod=produto&acao=listarProduto';
                },
                complete: function () {
                    $.fancybox.hideLoading();
                }
            });
        } else {
            location.href = 'index.php?mod=produto&acao=listarProduto';
        }
    });

    /*********************************************************************/
    /******************* CATEGORIAS *********************************/
    /*********************************************************************/
    $(".listCategorias").on("change", "select[name='idcategoria[]']", function () {
        ref = $(this);
        value = $(this).val();
        $(this).find("option").removeAttr("selected");
        $(this).val(value);
        refDivCat = $(ref).closest("div.categorias");
        if ($(this).val() == "") {
            html = "<option value=''></option>";
            $(refDivCat).find("select[name='idsubcategoria[]']").html("<option value=''></option>");
        } else {
            $.ajax({
                url: 'categoria_script.php',
                dataType: 'json',
                data: "opx=buscarCategorias&ordem=nome&dir=asc&idcategoria_pai=" + $(this).val(),
                type: 'post',
                beforeSend: function () {
                    $.fancybox.showLoading();
                }, 
                success: function (data) {

                    if (data.length > 0) {
                        $(refDivCat).find("select[name='idsubcategoria[]']").addClass("required").val("");
                        $(refDivCat).find(".box_ip").last().show();
                        html = "<option value=''></option>";
                        $selected = $("select[name='idsubcategoria[]']");
                        $.each(data, function (index, value) {
                            add = true;
                            $.each($selected, function (i, v) {
                                remove = $(this).closest("div.categorias").find("input[name='remover[]']").val();
                                if ($(this).val() == value.idcategoria && remove == 0) {
                                    add = false;
                                }
                            });
                            if (add) {
                                html += "<option value='" + value.idcategoria + "'>" + value.nome + "</option>";
                            }
                        });
                        $($(refDivCat)).find("select[name='idsubcategoria[]']").html(html);

                        if ($(ref).find("option").length == 2) {
                            //verifica total de subcategorias
                            if ($(refDivCat).find("select[name='idsubcategoria[]'] option").length == 2) {
                                $(refDivCat).find("select[name='idsubcategoria[]'] option").attr('selected', true);
                                $(refDivCat).find("select[name='idsubcategoria[]']").closest("div.box_sel").addClass("focus");
                                $(".maisCategoria").hide();
                            }
                        }
                    } else {
                        $(refDivCat).find("select[name='idsubcategoria[]']").removeClass("required").val("");
                        $(refDivCat).find(".box_ip").last().hide();
                    }
                },
                complete: function () {
                    $.fancybox.hideLoading();
                }
            });
        }
    });


    $(".listCategorias").on("change", "select[name='idsubcategoria[]']", function () {
        if ($(this).val() != "") {
            idsub = $(this).val();
            id = $(this).attr("id");
            ref = $(this);
            $selected = $("select[name='idsubcategoria[]']");
            $.each($selected, function (index, value) {
                remove = $(this).closest("div.categorias").find("input[name='remover[]']").val();
                if ($(this).val() == idsub && id != $(this).attr("id") && remove == 0) {
                    $(ref).val("");
                    alert("SubCategoria já selecionada");
                }
            });
        }
    });


    $(".maisCategoria").click(function (e) {

        e.preventDefault();
        valida = true;
        //verifica se esta todos marcados
        $(".listCategorias").find(".box_sel_d").css("border", "1px solid #e2e4e7");
        campos = $(".listCategorias").find("select.required");
        $.each(campos, function (value, index) {
            if (!$.trim($(this).val())) {
                $(this).closest(".box_sel_d").css("border", "solid 1px red");
                valida = false;
            }
        });

        if (valida) {
            numRand = Math.random();
            $("#one").find("select[name='idsubcategoria[]']").attr("id", numRand);
            $copy = $("#one").find(".categorias").clone(true);
            $(".listCategorias").append($copy);
            $(".listCategorias .categorias").last().hide();
            $("#one").find("select[name='idsubcategoria[]']").removeAttr("id");

            select = $(".listCategorias .categorias").last().find("select[name='idcategoria[]']");

            //seleciona as subcategorias, para nao trazer as já marcadas
            subcategorias = $(".listCategorias").find("select[name='idsubcategoria[]'].required");

            idsubcategorias = "";
            $.each(subcategorias, function (index, value) {
                remove = $(this).closest("div.categorias").find("input[name='remover[]']").val();
                if (value.value != "" && remove == 0) {
                    idsubcategorias += "," + value.value;
                }
            })

            if (idsubcategorias != "") {
                idsubcategorias = idsubcategorias.substr(1);
            }

            $.ajax({
                url: 'categoria_script.php',
                dataType: 'json',
                data: "opx=buscarCategorias&ordem=nome&dir=asc&subcategorias=true&admin=true&tipocategoria=1&not_idsubcategoria=" + idsubcategorias,
                type: 'post',
                beforeSend: function () {
                    $.fancybox.showLoading();
                },
                success: function (data) {
                    html = "";
                    $.each(data, function (index, value) {
                        subcategorias = value.subcategorias;
                        add = true;
                        if (subcategorias.length == 0) {
                            //para nao repetir a categoria se nao tiver subcategorias, e se ja estiver marcado
                            $verifica = $("select[name='idcategoria[]']");
                            $.each($verifica, function (i, k) {
                                if ($(this).val() == value.idcategoria) {
                                    add = false;
                                }
                            });
                        }
                        if (add) {
                            html += "<option value='" + value.idcategoria + "'>" + value.nome + "</option>";
                        }
                    });

                    if (html != "") {
                        html = "<option value=''></option>" + html;
                        $(select).html(html);
                        $(".listCategorias .categorias").last().show();

                        if ($(select).find("option").length == 2) {
                            $(select).find("option").last().attr('selected', true);
                            $(select).closest("div.box_sel").addClass("focus");
                            $(select).trigger('change');
                        }
                    } else {
                        $(select).closest(".categorias").remove();
                    }
                },
                complete: function () {
                    $.fancybox.hideLoading();
                }
            });
        }
    });

    $(".removerLinha").click(function (e) {
        e.preventDefault();
        ref = $(this).closest("div.categorias");
        $(".maisCategoria").show();
        if ($(ref).find("input[name='idproduto_categoria[]']").val() == 0) {
            $(ref).remove();
        } else {
            $(ref).find("select").removeClass("required");
            $(ref).find("input[name='remover[]']").val("-1");
            $(ref).hide();
        }
    });


    /////////////////URLREWRITE///////////////////////////////////

    $("#urlrewrite").blur(function (event) {
        event.preventDefault();
        if ($(this).val() != "" || $("#nome").val() != "") {
            url = $(this).val();
            if (url == "") {
                url = $("#nome").val();
                $("#urlrewrite").val($("#nome").val()).closest(".box_ip").addClass("focus");
            }
            verificaUrlrewrite(url);
        }
    });

    $("#nome").blur(function (event) {
        url = $("#urlrewrite").val();
        if (url == "") {
            nome = $("#nome").val();
            verificaUrlrewrite(nome);
        }
    });
    //////////////////////////////////////////////////// 


    $("#idcategoria_pai").change(function () {

        $.ajax({
            url: 'categoria_script.php',
            dataType: 'json',
            data: "opx=buscarCategorias&ordem=nome&dir=asc&idcategoria_pai=" + $(this).val(),
            type: 'post',
            beforeSend: function () {
                $.fancybox.showLoading();
                $('#idcategoria').html("<option value=''></option>");
            },
            success: function (data) {

                if (data.length > 0) {
                    html = "<option value=''></option>";
                    $.each(data, function (index, value) {
                        html += "<option value='" + value.idcategoria + "'>" + value.nome + "</option>";
                    });
                    $('#idcategoria').html(html);
                    $('.subcategoria').show();
                } else {
                    $('.subcategoria').hide();
                }
            },
            complete: function () {
                $.fancybox.hideLoading();
            }
        });
    });

    $(".maisModelo").click(function (e) {
        e.preventDefault();
        html = "<div class='modelo'><div class='input'><input type='text' name='modelos[]' value=''>";
        html += "<input type='hidden' name='idproduto_modelo[]' value='0'></div>";
        html += "<div class='divDelete'><a href='#' class='removerModelo'><img src='images/delete.png'  alt='Remover' title='Remover'></a></div></div>";
        $(".listModelo").append(html);
        $(".semModelos").remove();
    })

    $(".listModelo").on("click", ".removerModelo", function (e) {
        e.preventDefault();
        $(this).closest(".modelo").remove();
        if ($(".listModelo").find(".modelo").length == 0) {
            $(".listModelo").append("<span class='semModelos'>Nenhum modelo cadastrado</span>");
        }
    })
});


function verificaUrlrewrite(url) {
    id = 0;
    if ($("#mod").val() == 'editar') {
        id = $("#idproduto").val();
    }
    $.ajax({
        url: 'produto_script.php',
        dataType: 'json',
        data: "opx=verificarUrlRewrite&idproduto=" + id + "&urlrewrite=" + url,
        type: 'post',
        beforeSend: function () {
            $.fancybox.showLoading();
        },
        success: function (data) {
            if (!data.status) {
                msgErro("Url já cadastrado para outro Produto ou categoria");
                $("#urlrewrite").val($("#urlrewriteantigo").val());
            } else {
                $("#urlrewrite").val(data.url);
            }
        },
        complete: function () {
            $.fancybox.hideLoading();
        }
    });
}


////////////////////////////////////////////
///////// GALERIA DE IMAGENS //////////////
//////////////////////////////////////////

$(document).ready(function () {

    // ABRIR O BOX DE DESCRIÇÃO - da imagem
    $("#content-image").on("click", ".editImagemDescricao", function (e) {
        e.preventDefault();
        $("#formDescricaoImagem").find("#idImagem").val($(this).attr('idimagem'));
        var idimagemdescricao = $(this).attr('idimagem');
        var posImagem = $(this).closest("li").attr("id");
        $("#formDescricaoImagem").find("#descricao_imagem").val($(this).closest("li").find("input[name='descricao_imagem[]']").val());
        $("#formDescricaoImagem").find("#posImagem").val(posImagem);
        $("#boxDescricao").dialog({
            resizable: true,
            height: 140,
            width: 500,
            modal: true,
            title: 'Descrição da imagem:',
            open: function (event, ui) {
                $(this).find('.ui-dialog .ui-dialog-content').css('background-image', 'none!important;');
            }
        });
    });


    //SALVAR DESCRIÇÃO - confirmacao da descricao da imagem
    $("#boxDescricao").on("click", ".btSaveDescricao", function (e) {
        e.preventDefault();
        descricao = $("#boxDescricao").find("#descricao_imagem").val();
        idImagem = $("#boxDescricao").find("#idImagem").val();
        refImagem = $("#boxDescricao").find("#posImagem").val();
        $("#content-image li#" + refImagem).find("input[name='descricao_imagem[]']").val(descricao);

        if ($("#mod").val() == "editar") {
            //se for editando - salva direto no banco de dados
            $.ajax({
                url: 'produto_script.php',
                data: {
                    opx: 'salvarDescricao',
                    idImagem: idImagem,
                    descricao: descricao
                },
                dataType: 'json',
                type: 'post',
                beforeSend: function () {
                    $.fancybox.showLoading();
                },
                success: function (data) {

                    if (data.status == true) {
                        $("#boxDescricao").dialog("close");
                        $.fancybox.hideLoading();
                        msgSucesso('Descrição salva com sucesso', '');
                    } else {
                        $.fancybox.hideLoading();
                        msgErro('Erro ao salvar descrição');
                    }
                }
            });
        } else {
            $("#boxDescricao").dialog("close");
        }
    });


    //BOTÃO EXCLUIR - na imagem       
    $("#content-image").on("click", ".excluirImagem", function (e) {
        e.preventDefault();
        ref = $(this).closest("li");

        $("#formDeleteImagem").find("#idPosicao").val($(ref).attr('id'));

        var idimagemdescricao = $(ref).attr('idimagem');
        $("#excluirImagem").dialog({
            resizable: true,
            height: 140,
            width: 330,
            modal: true,
            title: 'Excluir imagem'
        });
    });


    //EXCLUI A FOTO SELECIONADA
    $(".btExcluirImagem").click(function (e) {

        e.preventDefault();
        idPosicao = $("#formDeleteImagem").find("#idPosicao").val();
        idproduto = $("#formProduto").find("#idproduto").val();
        idproduto_imagem = $("#" + idPosicao).find("input[name='idproduto_imagem[]']").val();
        imagem = $("#" + idPosicao).find("input[name='imagem_produto[]']").val();
        ref = $("#" + idPosicao);

        imagemDelete = $("#" + idPosicao).find("img").attr("src");
        imagemDelete = imagemDelete.replace('thumbnail2/', "thumbnail/");

        $.ajax({
            url: 'produto_script.php',
            type: 'post',
            dataType: 'json',
            data:
                {
                    opx: 'excluirImagemGaleria',
                    idproduto: idproduto,
                    imagem: imagem,
                    idproduto_imagem: idproduto_imagem
                },
            beforeSend: function () {
                $.fancybox.showLoading();
            },
            success: function (data) {
                if (data.status) {

                    //excluir imagem do post
                    var post = tinyMCE.get("descricao").getContent();
                    imagePost = tinyMCE.get("descricao").dom.select('img')
                    $.each(imagePost, function (nodes, name) {
                        img = tinyMCE.get("descricao").dom.select('img')[nodes];
                        if ($(img).attr("src") == imagemDelete) {
                            img.remove();
                        }
                    });

                    msgSucesso('Imagem excluída com sucesso!', '');
                    $(ref).remove();
                    resetOrdemImagens();
                } else {
                    msgErro('Erro ao excluir imagem, tente novamente', '');
                }
            },
            complete: function () {
                $.fancybox.hideLoading();
                $("#excluirImagem").dialog("close");
            }
        });
    });


    //EXCLUI A FOTO SELECIONADA
    $(".btCancelarExclusao").click(function (e) {
        $("#excluirImagem").dialog("close");
    });

    /* //BOTÃO POST - subir a imagem no texto
     $("#content-image").on("click",".postImagem",function(e){
         e.preventDefault();
         postImagem($(this));
     }); */


    //DRAG N DROP 
    $("#sortable").sortable({
        update: function (event, ui) {
            resetOrdemImagens();
        }
    });

    //SORTABLE IMAGES
    $("#sortable").disableSelection();


    $("#image").change(function () {
        enviaImagens(this);
    });


    tinymce.init({
        language: 'pt_BR',
        selector: '.mceAdvanced2',
        theme: "modern",
        plugins: [
          "advlist autolink lists link image charmap print preview hr anchor pagebreak",
          "searchreplace wordcount visualblocks visualchars code fullscreen",
          "insertdatetime media nonbreaking save table contextmenu directionality",
          "emoticons template textcolor colorpicker "
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        paste_data_images: true,
        table_toolbar: "tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
        table_appearance_options: false,
        table_default_styles: {
          fontWeight: 'bold'
        },
        setup: function (editor) {
          editor.on('blur', function (e) {
            var tinymax, tinylen, htmlcount;
            texto = this.getContent();
            this.setContent(texto);
          });
        }
      });
      

});


function verificaExt(input) {
    //passar o input.files[i]
    //verifica o tipo do arquivo
    switch (input.type) {
        //jpg permitido
        case 'image/jpeg':
            return true;
            break;
        //jpg permitido
        case 'image/png':
            return true;
            break;
        //jpg permitido
        case 'image/gif':
            return true;
            break;
        default:
            return false;
            break;
    }
}


//VERIFICA A IMAGEM A SER ENVIADA
function enviaImagens(input) {

    //variável com a posição da imagem;
    quantidadeimagem = $("#sortable").find('li').length;
    //quantas imagens estão sendo enviadas;
    var totalimagens = input.files.length;
    //tamanho máximo da imagem permitida pelo servidor;
    var tamanhoMaximo;
    tamanhoMaximo = ($("#fileMax").val()) * 1000000;
    var erros = "";


    //trata cada dado de arquivo enviado pelo input
    for (var i = 0; i < totalimagens; i++) {
        if (input.files && input.files[i]) {//verifica se tem dados no input
            if (verificaExt(input.files[i])) {//se valida a extensao do arquivo
                if (input.files[i].size > tamanhoMaximo) {
                    erros += 'A imagem "' + input.files[i].name + '"' + ' não foi enviada, pois, seu tamanho excede ' + $("#fileMax").val() + 'MB <br />';
                } else {
                    $.fancybox.showLoading();
                    quantidadeimagem++;
                    enviaImagensAjax(input.files[i], quantidadeimagem, totalimagens);
                }
            } else {//se não valida a extensao do arquivo
                erros += 'A imagem "' + input.files[i].name + '"' + ' não foi enviada, pois, sua extensão não é válida <br />';
            }
        } else {
            erros += 'Erro: O arquivo: "' + input.files[i].name + '" não foi enviado <br />';
        }
    }

    $.fancybox.hideLoading();

    if (erros != "") {
        msgErro(erros);
    }

}


//sobe a imagem
function enviaImagensAjax(input, posicao, limite) {

    var formData = new FormData();
    formData.append('opx', 'salvarGaleria');
    formData.append('imagem', input);
    formData.append('idproduto', $("#idproduto").val());
    formData.append('posicao', posicao);

    $.ajax({
        url: "produto_script.php",
        type: "POST",
        dataType: "json",
        data: formData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType
        async: false,
        //SE DER TUDO CERTO NO AJAX TEMOS QUE MUDAR ALGUMAS COISAS NOS "appends" ANTERIORES
        beforeSend: function () {
            $.fancybox.showLoading();
            $(".ui-sortable").css('opacity', 0.3);
        },
        success: function (data) {
            if (data.status == true) {

                $li = '<li class="ui-state-default' + posicao + ' move" id="' + posicao + '" idimagem="' + data.idproduto_imagem + '">';
                $li += '<img id="img' + posicao + '" class="imagem-gallery" style="opacity:1;" src="' + data.caminho + '">';
                $li += '<a class="editImagemDescricao" idimagem="' + data.idproduto_imagem + '" href="#"><button class="edit"></button></a>';
                $li += '<a class="excluirImagem" idimagemdelete="' + data.idproduto_imagem + '" href="#"><button class="delete"></button></a>';
                // $li += '<a class="postImagem" idimagempost="'+data.idproduto_imagem+'" href="#"><button class="post_imagem"></button></a>';
                $li += '<input type="hidden" name="idproduto_imagem[]" value="' + data.idproduto_imagem + '">';
                $li += '<input type="hidden" name="descricao_imagem[]" value="">';
                $li += '<input type="hidden" name="imagem_produto[]" value="' + data.nome_arquivo + '">';
                $li += '<input type="hidden" name="posicao_imagem[]" value="' + posicao + '">';
                $li += '</li>';

                $("#sortable").append($li);
                $("#idproduto").val(data.idproduto);

            }//fim if
            else {
                msgErro('Erro ao enviar imagem, por favor tente novamente!');
            }
        },
        complete: function (data) {
            $("#sortable").removeAttr("style");
        }
    });
    //fim AJAX
}

//ORDENA A POSICAO DAS IMAGENS SE UMA IMAGEM É APAGADA
function resetOrdemImagens() {

    $lis = $("#sortable").find("li");

    $.each($lis, function (index, value) {
        pos = parseInt(index) + parseInt(1);
        $(this).removeClass();
        $(this).addClass("ui-state-default" + pos + " move");
        $(this).attr("id", pos);
        $(this).find("input[name='posicao_imagem[]']").val(pos);
    });

    if ($("#mod").val() == "editar") {
        //editar a ordem das imagens
        form = $("#formProduto").serialize();

        $.ajax({
            url: "produto_script.php",
            type: "POST",
            dataType: "json",
            data: "opx=alterarPosicaoImagem&" + form,
            beforeSend: function () {
                $.fancybox.showLoading();
            },
            success: function (data) {
                if (data.status == true) {
                    $.fancybox.hideLoading();
                } else {
                    msgErro('Erro ao alterar posição da imagem. Tente novamente');
                }
            },
            complete: function (data) {
                $.fancybox.hideLoading();
            }
        });
    }
}

/*
function postImagem(campo){ 

    ref = $(campo).parent();
    imagem = $(ref).find("img").attr("src");     
    imagem = imagem.replace('thumbnail2/',"thumbnail/");
             
    //var post = tinyMCE.activeEditor.getContent(); 
    var post = tinyMCE.get("descricao").getContent();  
    post += '<img src="'+imagem+'" alt="" />';
    tinyMCE.get("descricao").setContent(post);
}
*/

// $(window).load(function () {
//     select = $(".listCategorias .categorias").last().find("select[name='idcategoria[]']");
//     selectSub = $(".listCategorias .categorias").last().find("select[name='idsubcategoria[]']");

//     if ($(select).find("option").length == 2 && $(selectSub).find("option").length == 2) {
//         $(".maisCategoria").hide();
//     }
// });
