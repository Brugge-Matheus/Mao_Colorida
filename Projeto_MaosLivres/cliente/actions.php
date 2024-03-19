<?php
@session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

 
if( (!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) && (!isset($_POST["opx"]) || empty($_POST["opx"])) ){
	return false;
	die;
}

$opx = ( (isset($_REQUEST["opx"]) && !empty($_REQUEST["opx"])) ? $_REQUEST["opx"] : $_POST["opx"] );

include_once(__DIR__.'/../admin/produto_class.php');

function calcula_total_orcamento( )
{
	$_SESSION['info_orcamento']['totais'] = array( 
		"subtotal"=>0,
		"desconto"=>0,
		"cashback"=>0,
		"frete"=>0,
		"total"=>0
	);

	if(isset($_SESSION['orcamento'])){

		// $_SESSION['info_orcamento']['totais']["frete"] = !empty($_SESSION['info_orcamento']['valor_frete']) ? $_SESSION['info_orcamento']['valor_frete'] : 0;

		foreach($_SESSION['orcamento'] as $prod){
			$total_produto =  $prod['qtde'] * (float)$prod['valor'];
			$dados_produto = buscaProduto(array("idproduto"=>$prod['idproduto']));

			$_SESSION['info_orcamento']['totais']["subtotal"] += $total_produto;
			$_SESSION['info_orcamento']['totais']["cashback"] += $total_produto * ( $prod['cashback']/100);

			if(!empty($_SESSION['info_orcamento']["voucher"]))
			{
				$voucher = $_SESSION['info_orcamento']["voucher"];

				if(empty($voucher["idproduto"]) && empty($voucher['idcategoria']) && empty($voucher['idsubcategoria']))
				{
					$_SESSION['info_orcamento']['totais']["desconto"] += ( $total_produto * ($voucher['desconto'] / 100) );
				}else if(!empty($voucher["idproduto"])) {
					if($voucher['idproduto'] == $dados_produto['idproduto']){
						$_SESSION['info_orcamento']['totais']["desconto"] += ( $total_produto * ($voucher['desconto'] / 100) );
					};
				}else if(!empty($voucher["idcategoria"])) {
					// $produto = buscaProduto(array("idproduto"=>$value['idproduto'],"idcategoria"=>$voucher['idsubcategoria'],"status_categoria"=>"A"));
					if($voucher['idcategoria'] == $dados_produto['idcategoria']){
						$_SESSION['info_orcamento']['totais']["desconto"] += ( $total_produto * ($voucher['desconto'] / 100) );
					};
				}else if(!empty($voucher["idsubcategoria"])) {
					if($voucher['idsubcategoria'] == $dados_produto['idsubcategoria']){
						$_SESSION['info_orcamento']['totais']["desconto"] += ( $total_produto * ($voucher['desconto'] / 100) );
					};
				};
			};
		};

		$totais = $_SESSION['info_orcamento']['totais'];

		$_SESSION['info_orcamento']['totais']["total"] = $totais["subtotal"] + $totais["frete"] - $totais["cashback"] - $totais["desconto"];
	};

	return array("status" => true, "totais" => $_SESSION['info_orcamento']['totais'], "remove_frete" => empty($_SESSION['info_orcamento']["codigo_modalidade_frete"]) );

};

switch ($opx) {

case 'add' :
		try {

			$produtos = array();

			if(isset($_SESSION['orcamento'])){
				$produtos = $_SESSION['orcamento'];
			};

			$dados = $_POST;

			$status = true;
			$produto = buscaProduto(array('idproduto' => $dados['idproduto']));

			if(empty($produto)){
				$status = false;
				$msg = "Erro ao adicionar produto ao orcamento. Produto não encontrado";
			}else{

				$produto = $produto[0];

				$id = $produto['idproduto'];
				
				//verifica total de produto já adicionado no orcamento;
				$totalGeral = (int)$dados['qtde'];
				// foreach ($produtos as $p => $prod) {
				// 	if( (int)$prod['idproduto'] == (int)$produto['idproduto'] ){
				// 		$posicao = $p; 
				// 		$totalGeral += (int)$prod['qtde'];
				// 	};
				// };

				// if( (int)$dados['qtde'] >  (int)$produto['estoque'] ||  (int)$totalGeral >  (int)$produto['estoque']){
				// 	$status = false;
				// 	$msg = "Estoque insuficiente do produto ".$produto['nome'];
				// 	$msg .= " <br/>Quantidade máxima de: ".$produto['estoque']."unidades";                 
				// };

				if($status === true){
					if (!isset($_SESSION['orcamento'])) {
						//total de produtos no orcamento
						$_SESSION['total_orcamento'] = 0;
					};
					if (!isset($_SESSION['orcamento'][$id])) {
						//adiciona item ao orcamento
						$_SESSION['orcamento'][$id] = array(
							'idproduto' => $produto['idproduto'],
							'nome' => $produto['nome'],
							'imagem' => $produto['imagem'],
							'urlcategoria' => $dados['urlcategoria'],
							'urlrewrite' => $produto['urlrewrite'],
							'qtde' => $dados['qtde']
							// 'valor' => ( !empty( (float)$produto['valor_promocao']) && (float)$produto['valor_promocao']<(float)$produto['valor'] ) ? (float)$produto['valor_promocao'] : (float)$produto['valor'],
							// 'largura' => $produto['largura'],
							// 'comprimento' => $produto['comprimento'],
							// 'cashback' => $produto['cashback'],
							// 'altura' => $produto['altura'],
							// 'peso' => $produto['peso']
						);
					} else {
						//adicionar novamente o mesmo produto, atualizar quantidade.
						$qtde = $_SESSION['orcamento'][$id]['qtde'];
						$_SESSION['orcamento'][$id]['qtde'] = $qtde + $dados['qtde'];
						// $_SESSION['orcamento'][$id]['valor'] = $produto['valor'];
						// $_SESSION['orcamento'][$id]['valor_promocao'] = $produto['valor_promocao'];
						// $_SESSION['orcamento'][$id]['largura'] = $produto['largura'];
						// $_SESSION['orcamento'][$id]['comprimento'] = $produto['comprimento'];
						// $_SESSION['orcamento'][$id]['altura'] = $produto['altura'];
						// $_SESSION['orcamento'][$id]['cashback'] = $produto['cashback'];
						// $_SESSION['orcamento'][$id]['peso'] = $produto['peso'];
					}

					$_SESSION['total_orcamento'] = $_SESSION['total_orcamento'] + $dados['qtde'];
					// unset($_SESSION['info_orcamento']['status_orcamento']);

					$totais = calcula_total_orcamento();

					echo json_encode(array('status' => true, 'produto' => $produto['nome'], 'total' => $_SESSION['total_orcamento'], 'totais' => $totais));

				}
				else
				{
					echo json_encode(array('status' => false, 'msg' =>$msg ));
				};
			};

			break;

		} catch (Exception $e) {
			echo json_encode(array('status' => false, 'msg' => "Erro ao adicionar produto ao orcamento"));
		};

	break;

	case 'remover' :
		$dados = $_POST;
		//atualiza total de produtos add no orcamento
		$total = $_SESSION['orcamento'][$dados['idproduto']]['qtde'];

		unset($_SESSION['orcamento'][$dados['idproduto']]);

		$_SESSION['total_orcamento'] = $_SESSION['total_orcamento'] - $total;

		$totais = calcula_total_orcamento();

		echo json_encode(array('status' => true, 'total' => $_SESSION['total_orcamento'], 'totais' => $totais ));
		
		if (empty($_SESSION['orcamento'])) {
			unset($_SESSION['orcamento'], $_SESSION['total_orcamento']);
		}

	break;

	case 'atualizaQtd' :
			$dados = $_POST;
	
			$produtos = array();
	
			if(isset($_SESSION['orcamento'])){
				$produtos = $_SESSION['orcamento'];
			};
	
			$status = true;
			$produto = buscaProduto(array('idproduto' => $dados['idproduto']));
			
			try
			{
				if(empty($produto)){
					$status = false;
					$msg = "Erro ao atualizar produto ao orcamento. Produto não encontrado";
				}
				else
				{
					$produto = $produto[0];
	
					$id = $produto['idproduto'];
					
					//verifica total de produto já adicionado no orcamento;
					$totalGeral = (int)$dados['qtde'];
					foreach ($produtos as $p => $prod) {
						if( (int)$prod['idproduto'] == (int)$produto['idproduto'] ){
							$posicao = $p; 
							$totalGeral += (int)$prod['qtde'];
						};
					};
	
					if( (int)$dados['qtde'] >  (int)$produto['estoque'] ||  (int)$totalGeral >  (int)$produto['estoque']){
						$status = false;
						$msg = "Estoque insuficiente do produto ".$produto['nome'];
						$msg .= " <br/> Quantidade máxima de: ".$produto['estoque']." unidades";                 
					};
	
					if($status === true){
	
						//atualiza total de produtos add no orcamento 
						$_SESSION['total_orcamento'] = $_SESSION['total_orcamento'] - $_SESSION['orcamento'][$produto['idproduto']]['qtde'];
						$_SESSION['total_orcamento'] = $_SESSION['total_orcamento'] + $dados['qtde'];
						$_SESSION['orcamento'][$produto['idproduto']]['qtde'] = $dados['qtde'];

						$totais = calcula_total_orcamento();
	
	
						echo json_encode( array('status' => true, "total" => $_SESSION['total_orcamento'], "totais" => $totais ) );
					}
					else
					{
						echo json_encode(array('status' => false, 'msg' =>$msg ));
					};
				};
			}
			catch (Exception $e)
			{
				echo json_encode(array('status' => false, 'msg' => "Erro ao atualizar produto ao orcamento"));
			};
	
	break;	
}