// Versao do modulo: 3.00.010416

var preventCache = Math.random();
var requestInicio = "";
var ordem = "";
var dir = "";
var pesquisar = "";
var limit = 20;
var pagina = 0;
var totalPaginasGrid = 1;
function preTableCategoria(){
		  $("#limit").change(function(){
          $("#pagina").val(1);
          dataTableCategoria();
	    });

	    $("#pagina").keyup(function(e){
          if(e.keyCode == 13){
            if(totalPaginasGrid >= $(this).val() && $(this).val() > 0){
                dataTableCategoria();
            }else{
                msgErro("numero de pagina deve ser entre 1 e "+totalPaginasGrid);
            }
          }
	    });

	    $(".next").click(function(e){
          e.preventDefault();
          $("#pagina").val($(this).attr('proximo'));
          dataTableCategoria();
	    });

	    $(".prev").click(function(e){
          e.preventDefault();
          $("#pagina").val($(this).attr('anterior'));
          dataTableCategoria();
	    });


	    //LISTAGEM BUSCA
	    $("#buscarapida").keyup(function(event){
	        event.preventDefault();
	        if(event.keyCode == '13') {
	            pesquisar = "&nome="+$("#buscarapida").val();
	            dataTableCategoria();
	        }
	        return true;
	    });

	    $("#filtrar").click(function(e){
	        e.preventDefault();
          if($("#tipocategoria").val() == "" || $("#tipocategoria").val() == 1){
              $("#idcategoria_pai").val("");
          }
	        pesquisar = "&"+$("#formAvancado").serialize();
	        dataTableCategoria();
	    });

	    $(".ordem").click(function(e){
	         e.preventDefault();
	         ordem = $(this).attr("ordem");
	         dir = $(this).attr("order");
	         $(".ordem").removeClass("action");
	         $(".ordem").removeClass("actionUp");
	         if($(this).attr("order") == "asc"){
	             $(this).attr("order","desc");
	             $(this).removeClass("action");
	             $(this).addClass("actionUp");
	         }else{
	             $(this).attr("order","asc");
	             $(this).removeClass("actionUp");
	             $(this).addClass("action");
	         }
	         dataTableCategoria();
	    });

}
	var myColumnDefs = [
		{key:"idcategoria", sortable:true, label:"ID", print:true, data:true},
		{key:"nome", sortable:true, label:"Nome", print:true, data:true},
		{key:"urlrewrite", sortable:true, label:"Urlrewrite", print:true, data:false},
		{key:"seotitle", sortable:true, label:"Seotitle", print:true, data:false},
		{key:"seodescrition", sortable:true, label:"Seodescrition", print:true, data:false},
		{key:"seokeywords", sortable:true, label:"Seokeywords", print:true, data:false},
		{key:"iconepositivo", sortable:true, label:"Iconepositivo", print:true, data:false},
		{key:"iconenegativo", sortable:true, label:"Iconenegativo", print:true, data:false},
        {key:"cor_", sortable:true, label:"Cor", print:true, data:false},
        {key:"destaque_home", sortable:true, label:"Destaque", print:true, data:false},
		{key:"status", sortable:true, label:"Status", print:true, data:false},
        {key:"status_icone", sortable:false, label:"Status",  print:false, data:true},
	]
function columnCategoria(){
	    tr = "";
	    $.each(myColumnDefs, function(col, ColumnDefs){
	    	if(ColumnDefs['data']){
	            orderAction = "";
	            ordena = "";
	            if(ColumnDefs['key'] == ordem){
	                if(dir == "desc"){
	                    orderAction = "actionUp";
	                }else{
	                    orderAction = "action";
	                }
	            }
	            if(ColumnDefs['sortable']){
	                ordena = 'ordem="'+ColumnDefs['key']+'" class="ordem '+orderAction+'" order="'+dir+'"';
	            }
	            tr += '<th><a href="#" '+ ordena +'>'+ColumnDefs['label']+'</a></th>';
	        }
	    });
	    tr += "<th></th>";
	    $('#listagem').find("thead").append(tr);
}


function dataTableCategoria(){
    limit = $("#limit").val();
    pagina = $("#pagina").val();
    pagina = parseInt(pagina) - 1;
    colunas = myColumnDefs;
    colunas = JSON.stringify(colunas);
    queryDataTable = requestInicio+"&ordem="+ordem+pesquisar+"&dir="+dir+"&colunas="+colunas;
    $.ajax({
       url: "base_proxy.php",
       dataType: "json",
       type: "post",
       data: requestInicio+"&limit="+limit+"&pagina="+pagina+"&ordem="+ordem+pesquisar+"&dir="+dir,
       beforeSend: function () {
          $.fancybox.showLoading();
          $('#listagem').find("tbody tr").remove();
       },
       success:function(data){
          tr = "";
          if(data.totalRecords > 0){
              $.each(data.records, function(index, value){
                tr += '<tr>';
                $.each(myColumnDefs, function(col, ColumnDefs){
                	if(ColumnDefs['data']){
              				key = ColumnDefs['key'];
                            if(key=='tipocategoria'){
                                if(value[key] == 1){
                                    value[key] = 'categoria'
                                }else{
                                     value[key] = 'sub-categoria'
                                }
                            }
              				tr += '<td><span>'+value[key]+'</span></td>';
              			}
                });

                tr += '<td><div class="acts">';
                tr += '<a href="index.php?mod=categoria&acao=formCategoria&met=editCategoria&idu='+value.idcategoria+'"><img src="images/ico_edit.png" height="16" width="16" alt="ico" /><div class="tt"><span class="one">Editar</span><span class="two"></span></div></a>';
                tr += '<a href="#" onclick="wConfirm(\'Excluir Registro\',\'Tem certeza que deseja excluir o registro '+value.nome+' ?\',\'php\', \'categoria_script.php?opx=deletaCategoria&idu='+value.idcategoria+'\');"><img src="images/ico_del.png" height="17" width="17" alt="ico" /><div class="tt"><span class="one">Excluir</span><span class="two"></span></div></a>';
                tr += '</div></td>';
              });
              $('#listagem').find("tbody").append(tr);
              atualizaPaginas(data.pageSize, (pagina + 1) , data.totalRecords);
              $('.pagination').show();
          }else{
              $('#listagem').find("tbody").append('<tr class="odd pesquisa_error"><td colspan="'+myColumnDefs.length+'">Nenhum resultado encontrado</td></tr>');
              $('.pagination').hide();
          }
       },
       complete:function(){
                $.fancybox.hideLoading();
       }
    });
}

 
$(document).ready(function(){

    $(".cancelar").click(function(e){
        e.preventDefault();
        if($("#idcategoria").val() == 0){
            if($("#imagem-value").val() != ''){
                cancelarImagem('categoria', $("#imagem-value").val());
            }
        }
        else{
            location.href='index.php?mod=categoria&acao=listarcategoria';
        }
    });

    $('.cropped-image').change(function(){
        if($(this).attr('id') == 'inputImage'){
            $('#img-container > img').cropper('setAspectRatio', $("#aspectRatioW").val()/$("#aspectRatioH").val());
            $('#cropper-modal').appendTo('#select-image-1');
            // $('#img-container').show();
            $('.save-cropped-image').attr('data-image-type','imagem');
            $('.save-cropped-image').show();
        }else{
            $('#img-container > img').cropper('setAspectRatio', $("#aspectRatioW2").val()/$("#aspectRatioH2").val());
            $('#cropper-modal').appendTo('#select-image-2');
            // $('#img-container').show();
            $('.save-cropped-image').attr('data-image-type','imagem_2');
            $('.save-cropped-image').show();
        }
    });

    $('.save-cropped-image').click(function(e){
        e.preventDefault();
        var dataImageType = $(this).attr('data-image-type');
        var formData = new FormData();
        var coordenadas = $("#img-container>img").cropper('getData');
        coordenadas = JSON.stringify(coordenadas, null, 4);

        if(dataImageType == 'imagem'){
            formData.append('imagemCadastrar', document.getElementById('inputImage').files[0]);
        }else{
            formData.append('imagemCadastrar', document.getElementById('inputImage2').files[0]);
        }
        formData.append('coordenadas', coordenadas);
        formData.append('opx', 'salvaImagem');
        formData.append('tipo', dataImageType);
        formData.append("idcategoria", $('input[name=idcategoria]').val());
        if(dataImageType == 'imagem'){
            formData.append("dimensaoWidth", $("#aspectRatioW").val());
            formData.append("dimensaoHeight", $("#aspectRatioH").val());
        }else{
            formData.append("dimensaoWidth", $("#aspectRatioW2").val());
            formData.append("dimensaoHeight", $("#aspectRatioH2").val());
        }

        $.ajax({
            url: "categoria_script.php",
            type: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend:function(){
                Loader.show();
            },
            success:function(data){
                console.log(data);
                if(data.status == true){
                    if(dataImageType == 'imagem'){
                        $('#imagem-value').val(data.imagem);
                        $('#select-image-1 .img-categoria-form').attr('src', 'files/categoria/'+data.imagem);
                        $('#select-image-1 .img_pricipal .box_ip').show();
                        $('.excluir-imagem[data-tipo='+dataImageType+']').attr('data-img',data.imagem);
                        $('.excluir-imagem[data-tipo='+dataImageType+']').show();
                    }else{
                        $('#imagem_2-value').val(data.imagem);
                        $('#select-image-2 .img-categoria-form').attr('src', 'files/categoria/'+data.imagem);
                        $('#select-image-2 .img_pricipal .box_ip').show();
                        $('.excluir-imagem[data-tipo='+dataImageType+']').attr('data-img',data.imagem);
                        $('.excluir-imagem[data-tipo='+dataImageType+']').show();
                    }
                    $('#img-container').hide();
                    $('.save-cropped-image').hide();
                }
                Loader.hide();
            }
        });
    });

    $("#inputImage").change(function(){
        var filename = $(this).val();
        var extension = filename.replace(/^.*\./, '');
        if (extension == filename) { extension = '';
        }else{ extension = extension.toLowerCase(); }
       
        if(extension != 'png' && extension != 'jpg' && extension != 'jpeg'){
          msgErro('A extensão deste arquivo não é permitida!');
          $(this).val('');
          return false;
        }
    });

    let tipo, img, thisElem;
    $(".excluir-imagem").click(function(){
        tipo = $(this).attr('data-tipo');
        img = $(this).attr('data-img');
        thisElem = $(this);
        $("#modal-confirmacao").dialog({
            resizable: true,
            height:140,
            width:330,
            modal: true,  
            title:'Excluir imagem'    
        });
    });

    $(".confirm").click(function(){
        excluirImagem('categoria', tipo, img, thisElem);
        $('.ui-dialog-titlebar-close').click();
    });

    $(".cancel").click(function(){
        $('.ui-dialog-titlebar-close').click();
    });

    $('.bt_save').click(function(){
        Loader.show();
    });
     
    function cancelarImagem(pasta, imagem){
        $.ajax({
            url: 'categoria_script.php',
            dataType: 'json',
            type: 'post',
            data: {opx: 'cancelarImagem', pasta: pasta, imagem: imagem},
            success: function(){
                location.href='index.php?mod=categoria&acao=listarCategoria';
            }
        });
    }

    if($("#tipocategoria").val() == "1" || $("#tipocategoria").val() == 0){
        $(".subcategoria").hide(""); 
        $(".categoria").show("");
        $("#idcategoria_pai").removeClass("required");
    }else{
        $(".subcategoria").show(""); 
        $(".categoria").hide("");
        $("#idcategoria_pai").addClass("required");
    } 


    $("#formCategoria").find("#tipocategoria").change(function(){  
        if($(this).val() == 1){
          $(".categoria").show(""); 
          $(".subcategoria").hide("");
          $("#idcategoria_pai").removeClass("required");
        }
        else if($(this).val() == 2){
          $(".categoria").hide("");  
          $(".subcategoria").show("");
          $("#idcategoria_pai").addClass("required"); 
        } 
    }) 

    $("#formAvancado").find("#tipocategoria").change(function(){ 
        if($(this).val() == 1){
           $(".categoria").hide();
        }
        else if($(this).val() == 2){
          $(".categoria").show();
        } 
        else{
          $(".categoria").hide();
        }
    }) 


    /////////////////URLREWRITE///////////////////////////////////

    $("#urlrewrite").blur(function(event){
        event.preventDefault();  
        if($(this).val() != "" || $("#nome").val() != ""){
          url = $(this).val();
          if(url == ""){
            url = $("#nome").val();
            $("#urlrewrite").val($("#nome").val()).closest(".box_ip").addClass("focus");
          }  
          verificaUrlrewrite(url); 
        }  
    }); 

    $("#nome").blur(function(event){
        url = $("#urlrewrite").val();
        if(url == ""){ 
          nome = $("#nome").val();  
          verificaUrlrewrite(nome);
        }   
    });
  ////////////////////////////////////////////////////
    
});

function removeSite(url){
  url = $("#urlrewrite").val();
  end = $("#_endereco").val(); 
  url = url.replace(end, ""); 
  return url;
}



function verificaUrlrewrite(url){
  id = 0; 
  if($("#mod").val()=='editar'){ 
      id = $("#idcategoria").val(); 
  }  
  $.ajax({
      url:'categoria_script.php',
      dataType:'json',
      data: "opx=verificarUrlRewrite&idcategoria="+id+"&urlrewrite="+url,
      type:'post',
      beforeSend:function(){
        $.fancybox.showLoading();
      },
      success:function(data){  
          if(!data.status){
              msgErro("Url já cadastrado para outro Produto ou categoria");
              $("#urlrewrite").val($("#urlrewriteantigo").val());
          }else{   
              $("#urlrewrite").val(data.url);
          }
      },
      complete:function(){
          $.fancybox.hideLoading();
      }
  });
}

