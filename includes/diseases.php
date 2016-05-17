<form class="form-vertical" method='post'>
    <h2 class="bs_heading">Diseases</h2>
    <select class="form-control bs_dropdown" name="disease">

        <?php 
                $disease_array = find_diseases( $_POST["bodySystem"] );
                echo disease_dropdown_list($disease_array);
        ?>

    </select>
    <input value="Select" type='submit' class="btn btn-default">
</form>