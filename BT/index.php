<html>
<head><meta http-equiv="content-type" charset="utf-8"></head>
<body>
    <div id="container">
    <div id="banner">
    <img src="images/banner.jpg" alt="Banner" style="width:100%; height:100%;">
</div>
        <div id="menu"></div>
        <div id="lmenu"><?php include "lmenu.php";?></div>
        <div id="content"><?php include "content.php"; ?></div>
        <br style="clear:both;">
        <div id="footer"></div>
    </div>
    <style>
        body{margin:0px;}
        #container{width:1000px; margin:0px auto;}
        #banner{height:150px; background-color:#39C}
        #menu{height:30px; background-color:red;}
        #lmenu{height:400px; width:200px; background-color:#FC6; float:left;/*bỏ height*/}
        #content{min-height:400px;  /* tối thiểu 400px, vẫn đẹp khi nội dung ít */
    width:800px;
    background-color:#9F3;
    float:left;
    overflow:auto;}
        #footer{height:200px; background-color:#096;}
    </style>
</body>
</html>
