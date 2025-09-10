<?php
session_start();

// (a) Khai báo mảng Nhan Vien
if (!isset($_SESSION['dsNhanVien'])) {
    $_SESSION['dsNhanVien'] = [];
    $_SESSION['auto_id'] = 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // (b) Thêm chức năng nhập thông tin nhân viên (ID tự động)
    if ($action === 'add') {
        $hoten = $_POST['hoten'];
        $tuoi = $_POST['tuoi'];
        $hsl = $_POST['hsl'];
        $id = $_SESSION['auto_id']++;

        $_SESSION['dsNhanVien'][] = [$id, $hoten, $tuoi, $hsl];
        header('Content-Type: application/json');
        echo json_encode(["status"=>"ok"]);
        exit;
    }

    // (b) Xóa nhân viên (có nút X)
    if ($action === 'delete') {
        $idDel = $_POST['id'];
        foreach ($_SESSION['dsNhanVien'] as $k => $nv) {
            if ($nv[0] == $idDel) unset($_SESSION['dsNhanVien'][$k]);
        }
        $_SESSION['dsNhanVien'] = array_values($_SESSION['dsNhanVien']);
        if (count($_SESSION['dsNhanVien']) === 0) $_SESSION['auto_id'] = 1;
        header('Content-Type: application/json');
        echo json_encode($_SESSION['dsNhanVien']);
        exit;
    }

    // (d) Load danh sách nhân viên để hiển thị bảng
    if ($action === 'load') {
        header('Content-Type: application/json');
        echo json_encode($_SESSION['dsNhanVien']);
        exit;
    }

    // (c) Khởi tạo nhiều đối tượng nhân viên mẫu
    if ($action === 'init') {
        $_SESSION['dsNhanVien'] = [
            [$_SESSION['auto_id']++, "Nguyen Van A", 25, 2.5],
            [$_SESSION['auto_id']++, "Tran Thi B", 30, 3.0],
            [$_SESSION['auto_id']++, "Le Van C", 28, 2.8],
        ];
        header('Content-Type: application/json');
        echo json_encode($_SESSION['dsNhanVien']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý nhân viên</title>
  <style>
    /* Thiết kế giao diện chuyên nghiệp, đẹp mắt */
    body { font-family: 'Segoe UI', sans-serif; margin: 30px; background: #f4f6f9; }
    h2 { color: #333; }
    .form-box { background: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); margin-bottom: 15px; }
    input, button { padding: 8px 10px; margin: 5px; border-radius: 6px; border: 1px solid #ccc; }
    button { cursor: pointer; background: #3498db; color: #fff; border: none; transition: 0.2s; }
    button:hover { background: #2980b9; }
    #controls button { background: #2ecc71; }
    #controls button:hover { background: #27ae60; }
    table { border-collapse: collapse; width: 100%; margin-top: 15px; background: #fff; border-radius: 10px; overflow: hidden; display: none; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background: #3498db; color: #fff; }
    tbody tr:hover { background: #f1f1f1; }
    .btn-del { background: #e74c3c; }
    .btn-del:hover { background: #c0392b; }
  </style>
</head>
<body>
  <h2>Quản lý Nhân viên</h2>

  <!-- (b) Form nhập liệu nhân viên -->
  <div class="form-box">
    <form id="formNV">
      Họ tên: <input type="text" id="hoten" required>
      Tuổi: <input type="number" id="tuoi" required>
      Hệ số lương: <input type="number" step="0.1" id="hsl" required>
      <button type="submit">Thêm nhân viên</button>
    </form>
  </div>

  <!-- Nút điều khiển -->
  <div id="controls">
    <button id="btnLoad">Load</button> <!-- (d) Hiển thị bảng -->
    <button id="btnInit">Khởi tạo danh sách mẫu</button> <!-- (c) -->
    <button id="btnRandom">Màu ngẫu nhiên</button> <!-- (e) -->
    <button id="btnZebra">Màu chẵn/lẻ</button> <!-- (f) -->
  </div>

  <!-- (d) Bảng hiển thị danh sách nhân viên -->
  <table id="tblNV">
    <thead>
      <tr>
        <th>ID</th><th>Họ tên</th><th>Tuổi</th><th>HSL</th><th>Hành động</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  <script>
    const tbl = document.querySelector("#tblNV tbody");
    const table = document.getElementById("tblNV");

    // (d) Hàm tạo bảng hiển thị nhân viên
    function renderTable(data) {
      tbl.innerHTML = "";
      data.forEach(nv => {
        let row = tbl.insertRow();
        nv.forEach(val => {
          let cell = row.insertCell();
          cell.textContent = val;
        });
        let cell = row.insertCell();
        let btn = document.createElement("button");
        btn.textContent = "X";
        btn.className = "btn-del";
        btn.onclick = () => deleteNV(nv[0]); // (b) Xóa nhân viên
        cell.appendChild(btn);
      });
      table.style.display = data.length > 0 ? "table" : "none";
    }

    // (d) Load dữ liệu từ server
    function loadNV() {
      let params = new URLSearchParams();
      params.append("action", "load");
      fetch("nhanvien.php", { method: "POST", body: params })
        .then(res => res.json())
        .then(data => renderTable(data));
    }

    // (b) Xóa nhân viên
    function deleteNV(id) {
      let params = new URLSearchParams();
      params.append("action","delete");
      params.append("id",id);
      fetch("nhanvien.php", { method:"POST", body: params })
        .then(res=>res.json())
        .then(data => renderTable(data));
    }

    // (b) Thêm nhân viên (chỉ lưu, chưa hiển thị)
    document.getElementById("formNV").addEventListener("submit", function(e){
      e.preventDefault();
      let hoten = document.getElementById("hoten").value;
      let tuoi = document.getElementById("tuoi").value;
      let hsl = document.getElementById("hsl").value;

      let params = new URLSearchParams();
      params.append("action","add");
      params.append("hoten", hoten);
      params.append("tuoi", tuoi);
      params.append("hsl", hsl);

      fetch("nhanvien.php", { method: "POST", body: params })
        .then(res=>res.json())
        .then(() => {
          alert("Đã thêm nhân viên thành công!"); 
          document.getElementById("formNV").reset();
        });
    });

    // (d) Nút Load
    document.getElementById("btnLoad").onclick = loadNV;

    // (c) Nút khởi tạo mẫu
    document.getElementById("btnInit").onclick = function(){
      let params = new URLSearchParams();
      params.append("action","init");
      fetch("nhanvien.php",{ method:"POST", body: params })
        .then(res=>res.json())
        .then(data => renderTable(data));
    };

    // (e) Hàm tạo màu ngẫu nhiên cho từng dòng
    document.getElementById("btnRandom").onclick = function(){
      Array.from(tbl.rows).forEach(r=>{
        r.style.backgroundColor = "#"+Math.floor(Math.random()*16777215).toString(16);
      });
    };

    // (f) Hàm tạo màu chẵn/lẻ trắng – xám
    document.getElementById("btnZebra").onclick = function(){
      Array.from(tbl.rows).forEach((r,i)=>{
        r.style.backgroundColor = (i%2==0) ? "#fff" : "#eee";
      });
    };
  </script>
</body>
</html>
