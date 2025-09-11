<?php
    require_once "data.php";
    $cag = $_GET['gr'];
    if(!$cag || !array_key_exists($cag, $data)){
        $keys=array_keys($data);
        header("Location: .?gr=".($keys[0]));
    }
    $man = $data[$cag];
    foreach($man as $mankey=>$manval){
        echo "<div class='nav_bar'>".$mankey."</div>";
        echo "<div style='padding-bottom:15px;'>";
        foreach($manval as $prod){
            $imgFile = "images/products/" . strtolower(str_replace(" ", "-", $prod)) . ".jpg";

    echo "<div class='prd_item'>";
    if(file_exists($imgFile)){
        echo "<img src='".$imgFile."' alt='".$prod."'>";
    }
    echo "<div class='prd_name'>".$prod."</div>";
    echo "</div>";
        }
        echo "<br style='clear:both'>";
        echo "</div>";
    }
?>
<style>
    .nav_bar{
        padding:3px 5px;
        background-color:#036;
        color:white;
        font-weight:bold;
        margin-top:5px;
    }
    .prd_item{
    width:152px;
    height:150px;            /* đủ chỗ cho ảnh + chữ */
    background-color:#f5f5f5;
    border:solid 1px #ccc;
    text-align:center;
    padding:5px;
    margin:5px;
    float:left;
    border-radius:6px;
}

.prd_item img{
    max-width:100%;
    max-height:120px;
    display:block;
    margin:0 auto 5px auto;
}

.prd_name{
    font-size:14px;
    font-weight:bold;
    color:#333;
}
</style>
