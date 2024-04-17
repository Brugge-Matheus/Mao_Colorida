<div class="paginacao">
    <!-- <?php
        $paginas  = ceil( (int)$totais["totalRecords"] / $limit);
        $limit_buttons = 4;
        $pag_init_butttons = $paginas > $limit_buttons && $pagina > ceil( $limit_buttons / 2 ) ? ( $pagina -  ceil( $limit_buttons / 2 ) + 1 )  : 1;
        $pag_limit_butttons = ($pag_init_butttons + $limit_buttons ) > $paginas ? $paginas : ( $pag_init_butttons + $limit_buttons ) ;
           //echo "Limit: ".$limit . " <BR>| paginas:".$paginas . " <BR>| totalRecords:".(int)$totais["totalRecords"] . " <BR>| limit_buttons: ".$limit_buttons . " <BR>| pag_init_butttons: ".$pag_init_butttons . " <BR>| pag_limit_butttons: ".$pag_limit_butttons;
        $search = !empty($_REQUEST["search"]) ? "?search=".$_REQUEST["search"] : "";
        $ordem = !empty($_REQUEST["ordem"]) ? (!empty($search) ? "&" : "?")."ordem=".$_REQUEST["ordem"] : "";

        if($pag_limit_butttons > 1)
        {  ?> 
            <ul class='lista-paginacao d-flex'>
                <?php 
                if( $pag_init_butttons > 1)
                {
                    echo "<span class='nav prev'><a href='".$urlpag."/".($pag_init_butttons -1).$search.$ordem."'>❮</a></span>";
                };
                for ($pag = $pag_init_butttons; $pag <= $pag_limit_butttons; $pag++) { 
                    if($pagina == $pag ){
                        echo  "<li><a href='javascript:;' class='active'>".$pag."</a></li>";
                    }else {
                        echo  "<li><a href='".$urlpag.(($pag > 1)? "/".$pag:"").$search.$ordem."'>".$pag."</a></li>";
                    };
                };
                if( $pag_limit_butttons < $paginas)
                {
                    echo  "<span class='nav next'><a href='".$urlpag.(($pag > 1)? "/".$pag:"").$search.$ordem."'>❯</a></span>";
                };
                ?>
            </ul>
        <?php };
    ?> -->

    <ul class='lista-paginacao d-flex'>
        <span class='nav prev'><a href="">❮</a></span>
        <li><a href='' class='active'>1</a></li>
        <li><a href='' class=''>2</a></li>
        <li><a href='' class=''>3</a></li>
        <li><a href='' class=''>4</a></li>
        <span class='nav next'><a href="">❯</a></span>

    </ul>
</div> 
