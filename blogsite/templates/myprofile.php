<?php include("includes/header.php"); ?>
<div class="container">
    <?php
    echo "<pre>";
    //print_r($result);

    foreach($result['data'] as $key =>$value){
        //print_r($value);
        foreach($value['title'] as $title){
            print_r($title);
        }
    }
    ?>
</div>
<?php include("includes/footer.php"); ?>