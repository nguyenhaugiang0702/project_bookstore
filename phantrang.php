    <?php
    
        if($page_now > 3){
            $first_page = 1;
            ?>
                <a href="?slsach_on_page=<?=$sldislay?>&page=<?=$first_page?>">
                    <button class="btn btn-light border-dark">First</button>
                </a>
            <?php
            
        }
        if($page_now > 1){
            $prev_page=$page_now - 1;
            ?>
                <a href="?slsach_on_page=<?=$sldislay?>&page=<?=$prev_page?>">
                    <button class="btn btn-light border-dark">Prev</button>
                </a>
            <?php

        }
        
        for($i=1; $i<=$tongPage; $i++){
            ?>
                <?php
                    if($i != $page_now){
                        if($i > $page_now - 3 && $i < $page_now + 3  ){
                            ?>
                                <a href="?slsach_on_page=<?=$sldislay?>&page=<?=$i?>">
                                    <button class="btn btn-light border-dark"><?=$i?></button>
                                </a>
                            <?php 
                        }
                    }else{
                        ?>
                            <a href="?slsach_on_page=<?=$sldislay?>&page=<?=$i?>">
                                <button class="btn btn-secondary border-dark"><?=$i?></button>
                            </a>                                       
                        <?php
                    }
                ?>
                
            <?php
        }
        if($page_now < $tongPage - 1){
            $next_page = $page_now + 1;
            ?>
                <a href="?slsach_on_page=<?=$sldislay?>&page=<?=$next_page?>">
                    <button class="btn btn-light border-dark">Next</button>
                </a>
            <?php

        }
        if($page_now < $tongPage - 3){
            $end_page = $tongPage;
            ?>
                <a href="?slsach_on_page=<?=$sldislay?>&page=<?=$end_page?>">
                    <button class="btn btn-light border-dark">Last</button>
                </a>
            <?php

        }
    ?>
