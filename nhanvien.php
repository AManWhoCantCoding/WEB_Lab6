<?php
// d) Khởi tạo mảng nhiều nhân viên bằng mảng thường (dữ liệu ban đầu trong PHP)
$dsNhanVien = array(
    array("id" => 1, "hoten" => "Nguyen Van A", "tuoi" => 22, "hsl" => 3.2),
    array("id" => 2, "hoten" => "Tran Thi B", "tuoi" => 24, "hsl" => 2.8),
    array("id" => 3, "hoten" => "Le Van C", "tuoi" => 26, "hsl" => 3.5)
);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Nhân viên</title>
<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h2 { color: #333; }
    input { margin: 5px; padding: 6px; }
    button { margin: 5px; padding: 8px 14px; cursor: pointer; border-radius: 5px; }
    #message { color: green; font-weight: bold; margin-top: 10px; }
    table { border-collapse: collapse; margin-top: 15px; width: 100%; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background-color: #f2f2f2; }
    .delete-btn { background: red; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px; }
    .delete-btn:hover { background: darkred; }
</style>
</head>
<body>
    <h2>Quản lý Nhân viên</h2>

    <div>
        <input type="text" id="hoten" placeholder="Họ tên">
        <input type="number" id="tuoi" placeholder="Tuổi">
        <input type="number" id="hsl" placeholder="Hệ số lương" step="0.1">
        <button onclick="addNhanVien()">Thêm nhân viên</button>
        <button onclick="loadTable()">Load</button>
        <button onclick="setRandomColors()">Màu ngẫu nhiên</button>
        <button onclick="setEvenOddColors()">Màu chẵn/lẻ</button>
    </div>

    <div id="message"></div>
    <div id="table-container"></div>

<script>
    let nhanVienArr = <?php echo json_encode($dsNhanVien); ?>;  // dữ liệu khởi tạo từ PHP
    let autoId = nhanVienArr.length + 1; 
    let tableLoaded = false; 

    // b) Thêm nhân viên (chỉ thêm vào mảng, chưa hiển thị bảng)
    function addNhanVien() {
        let hoten = document.getElementById("hoten").value.trim();
        let tuoi = document.getElementById("tuoi").value.trim();
        let hsl = document.getElementById("hsl").value.trim();

        if (!hoten || !tuoi || !hsl) {
            alert("Vui lòng nhập đầy đủ thông tin!");
            return;
        }

        let nv = { id: autoId++, hoten, tuoi, hsl };
        nhanVienArr.push(nv);

        document.getElementById("message").innerText = "Đã thêm thông tin nhân viên thành công!";
        document.getElementById("hoten").value = "";
        document.getElementById("tuoi").value = "";
        document.getElementById("hsl").value = "";
    }

    // c) Load bảng (chỉ khi bấm mới hiển thị)
    function loadTable() {
        tableLoaded = true;
        renderTable();
    }

    // e) Render bảng
    function renderTable() {
        if (!tableLoaded) return;

        let html = "<table><tr><th>ID</th><th>Họ tên</th><th>Tuổi</th><th>Hệ số lương</th><th>Xóa</th></tr>";
        nhanVienArr.forEach((nv, index) => {
            html += `<tr>
                        <td>${nv.id}</td>
                        <td>${nv.hoten}</td>
                        <td>${nv.tuoi}</td>
                        <td>${nv.hsl}</td>
                        <td><button class='delete-btn' onclick='deleteRow(${index})'>X</button></td>
                     </tr>`;
        });
        html += "</table>";
        document.getElementById("table-container").innerHTML = html;
    }

    // b) Xóa nhân viên
    function deleteRow(index) {
        nhanVienArr.splice(index, 1);
        renderTable();
    }

    // f) Màu ngẫu nhiên
    function setRandomColors() {
        let rows = document.querySelectorAll("#table-container table tr");
        rows.forEach((row, i) => {
            if (i === 0) return; 
            row.style.backgroundColor = getRandomColor();
        });
    }
    function getRandomColor() {
        let letters = "0123456789ABCDEF";
        let color = "#";
        for (let i=0; i<6; i++) color += letters[Math.floor(Math.random()*16)];
        return color;
    }

    // g) Màu chẵn/lẻ
    function setEvenOddColors() {
        let rows = document.querySelectorAll("#table-container table tr");
        rows.forEach((row, i) => {
            if (i === 0) return;
            if (i % 2 === 0) row.style.backgroundColor = "#4e4d4ddf";
            else row.style.backgroundColor = "#212121ff";
        });
    }
</script>
</body>
</html>
