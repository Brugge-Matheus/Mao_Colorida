<?php 
    include_once __DIR__.'/../admin/linhas_class.php';
    include_once __DIR__.'/../admin/segmento_class.php';
    include_once __DIR__.'/../admin/categoria_class.php';

    $linhas = buscaLinhas(array('status' => 'A'));
    $segmentos = buscaSegmento(array('status' => '1'));
?>
<header class="header">
    <div class="header-container container">
        <a href="home" class="header-logo logo-branco"><img src="imagens/header/logo1.png" alt="imagem"></a>
        <div class="input-pesq">
            <input type="" name="" placeholder="O que você procura?">
            <button><i class="fas fa-search"></i></button>
        </div>
        <div class="mobile-menu">
            <a href="javascript:void(0)" class="open-mobile"><i class="fas fa-bars"></i></a>
        </div>
        <nav class="header-menu">
            <a href="sobre" class="header-link">Quem somos</a>
            <a href="contato" class="header-link">Contato</a>
            <a href="blog" class="header-link">Blog</a>
            <a href="revendedor" class="header-link">Revendedor</a>
            <a href="orcamento" class="orcamento-btn"><i class="fas fa-shopping-cart"></i> Orçamento</a>
        </nav>

        <!-- MENU MOBILE -->
        <nav class="header-mobile">
            <a href="javascript:void(0)" class="close-mobile">
                <i class="fas fa-times"></i>
            </a>
            <a href="home" class="header-logo logo-branco"><img src="imagens/header/logo1.png" alt="imagem"></a>
            <a href="sobre" class="header-link">Quem somos</a>
            <a href="contato" class="header-link">Contato</a>
            <a href="blog" class="header-link">Blog</a>
            <a href="revendedor" class="header-link">Revendedor</a>
            <?php foreach($linhas as $key => $l):?>
            <div class="menu-dropdown1">
                <a class="menu-link"><?= $l['nome'] ?></a>
                <ul>
                    <li>
                        <a class="produtos/linhas/<?= $l['urlrewrite'] ?>">Todos</a>
                    </li>
                    <?php 
                        $idlinhas = $l['idlinhas'];

                        $buscaCat = buscaCategoria(array('idlinhas' => $idlinhas));
                    ?>
                    <?php foreach($buscaCat as $key => $bC): ?>
                    <li>
                        <a><?= $bC['nome'] ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
            <div class="menu-dropdown1">
                <a class="menu-link">Segmentos</a>
                <ul>
                    <?php foreach($segmentos as $key => $s): ?>
                    <li>
                        <a href="segmento/<?= $s['urlrewrite'] ?>"><?= $s['nome'] ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a href="orcamento" class="orcamento-btn"><i class="fas fa-shopping-cart"></i> Orçamento</a>
        </nav>   
    </div>
</header>
<div class="menu">
    <nav class="container">
        <div class="menu-dropdown">
            <a class="menu-link cat-desktop"><i class="fas fa-bars"></i> Categorias <i class="fas fa-angle-down"></i></a>
            <div class="drop-menu drawer">
                <?php foreach($linhas as $key => $l2): ?>
                    <div class="menu-div">
                        <span><?= $l2['nome'] ?></span>
                        <ul>
                            <?php 
                                $idlinhas2 = $l2['idlinhas'];

                                $buscaCat2 = buscaCategoria(array('idlinhas' => $idlinhas2));
                            ?>
                            <?php foreach($buscaCat2 as $key => $bC2): ?>
                            <li>
                                <a href="<?= $bC2['urlrewrite'] ?>"><?= $bC2['nome'] ?> <i class="fas fa-angle-right"></i></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php foreach($linhas as $key => $l1): ?>
            <div class="menu-hover">
            <a href="produtos/linhas/<?= $l1['urlrewrite'] ?>" class="menu-link"><?= $l1['nome'] ?></a>
            <ul class="hover-div">
                <?php 
                    $idlinhas1 = $l1['idlinhas'];

                    $buscaCat1 = buscaCategoria(array('idlinhas' => $idlinhas1));
                ?>
                <?php foreach($buscaCat1 as $key => $bC1): ?>
                <li>
                    <a href="produtos/categoria/<?= $bC1['urlrewrite'] ?>"><?= $bC1['nome'] ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        |
        <?php endforeach; ?>
        <div class="menu-hover">
            <a href="segmento" class="menu-link">Segmentos</a>
            <?php  ?>
            <ul class="hover-div">
                <?php foreach($segmentos as $key => $seg): ?>
                <li>
                    <a href="segmento/<?= $seg['urlrewrite'] ?>"><?= $seg['nome'] ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
    </nav>
</div>
<div class="menu-paginas">
    <div class="container">
        <a href="home"><i class="fas fa-home"></i></a>
        <a href="<?php echo $_SESSION['modulo'] ?>"><i class="fas fa-chevron-right"></i><?php echo ucfirst($_SESSION['modulo']) ?></a>
        <?php if(!empty($_SESSION['idu'])): ?>
        <a href="<?php echo $_SESSION['modulo'].'/'.$_SESSION['idu'] ?>"><i class="fas fa-chevron-right"></i><?php echo ucfirst($_SESSION['idu']) ?></a>
        <?php endif; ?>
        <?php if(!empty($_SESSION['extra'])): ?>
        <a href="<?php echo $_SESSION['modulo'].'/'.$_SESSION['idu'].'/'.$_SESSION['extra'] ?>"><i class="fas fa-chevron-right"></i><?php echo ucfirst($_SESSION['extra']) ?></a>
        <?php endif; ?>
    </div>
</div>
