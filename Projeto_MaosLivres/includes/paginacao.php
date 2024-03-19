<div class="paginacao">
    <ul class="lista-paginacao d-flex">
        <?php
        if($total > 1) {

            if($pag > 0){
                echo "<span class='nav prev'><a href='".$urlpag.(($pag > 1)? "/".$pag:"")."'>❮</a></span>";
            }

            $total_paginas = $total;

            $aux = 0;
            $pagAux = 0;

            if($total_paginas > 5)
                $limitPaginacao = 4;
            else
                $limitPaginacao = $total_paginas - 1;

            if($pag >= 3) {
                $pagAux = $pag - 2; 
                if(($pag + 1) == $total_paginas)
                    $limitPaginacao = $limitPaginacao - 1;
            } 

            while($aux <= $limitPaginacao) {
                $num = $pagAux + 1;

                if($pagAux == $pag){
                    echo  "<li><a href='javascript:;' class='ativo'>".$num."</a></li>";
                }else if($num<= $total_paginas){
                    echo  "<li><a href='".$urlpag.(($num > 1)? "/".$num:"")."'>".$num."</a></li>";
                }   

                $pagAux = $pagAux + 1;
                $aux = $aux + 1;
            }

            if($pag < $total - 1){
                echo '<span class="nav next"><a href="'.$urlpag."/".($pag + 2).'">❯</a></span>';
            }
        } 
        ?>
    </ul>
</div> 