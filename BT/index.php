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
        <div id="footer">
    <div class="footer-col">
        <h3>Thông tin cửa hàng</h3>
        <p>LaptopStore XYZ</p>
        <p>Địa chỉ: 123 Đường ABC, Quận 1, TP.HCM</p>
        <p>Hotline: 0909 123 456</p>
    </div>
    <div class="footer-col">
        <h3>Liên hệ</h3>
        <p>Email: contact@laptopstore.com</p>
        <p>Fanpage: facebook.com/laptopstore</p>
        <p>Youtube: LaptopStore Channel</p>
    </div>
    <div class="footer-col">
        <h3>Chính sách</h3>
        <p>Giao hàng toàn quốc</p>
        <p>Bảo hành 12 tháng</p>
        <p>Đổi trả trong 7 ngày</p>
    </div>
    <div style="clear:both;"></div>
</div>
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
    #footer{
    background-color:#096;
    color:white;
    padding:20px 10px;
    min-height:200px;
    font-family:Arial, sans-serif;
    font-size:14px;
}

#footer h3{
    margin-top:0;
    margin-bottom:10px;
    font-size:16px;
    border-bottom:1px solid #0cf;
    padding-bottom:5px;
}

.footer-col{
    float:left;
    width:33.33%;
    padding:0 10px;
    box-sizing:border-box;
}

#footer p{
    margin:5px 0;
}

#footer:after{
    content:"";
    display:block;
    clear:both;
}
    </style>
</body>
</html>
