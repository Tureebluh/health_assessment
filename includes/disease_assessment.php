<div class="panel disease_info">    
    <?php

            $selected_disease = find_disease_by_id( $_POST["disease"] );
            echo disease_info($selected_disease);

    ?>
</div>