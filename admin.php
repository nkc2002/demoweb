<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin - Thế giới điện thoại</title>
    <link rel="shortcut icon" href="img/favicon.ico" />

    <!-- Load font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">

    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>

    <!-- Our files -->
    <link rel="stylesheet" href="FrontEnd/css/admin/style.css">
    <link rel="stylesheet" href="FrontEnd/css/admin/progress.css">

    <script src="data/products.js"></script>
    <script src="js/classes.js"></script>
    <script src="js/dungchung.js"></script>
    <script src="js/admin.js"></script>
</head>

<body>
    <!-- =============== Phần lấy dữ liệu từ DB ===================== -->
    <script type="text/javascript">
        // Đổ dữ liệu từ $dssp vào biến của javascript, dạng JSON
        $('document').ready(function(){
            $.ajax({       
            type: "post",
            url: "sanpham.php",
            dataType: "json",
            data : {
                         number : "1",                    },  
            success: function(data){           
                var list_products = data;
                addTableProducts(list_products);
                },
           });
        });
        
    </script>
    <!-- ================ Kết thúc lấy dữ liệu ======================= -->

    <header>
        <h2>SmartPhone Store - Admin</h2>
    </header>

    <!-- Menu -->
    <aside class="sidebar">
        <ul class="nav">
            <li class="nav-title">MENU</li>
            <li class="nav-item"><a class="nav-link active"><i class="fa fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link"><i class="fa fa-th-large"></i> Sản Phẩm</a></li>
            <li class="nav-item"><a class="nav-link"><i class="fa fa-file-text-o"></i> Đơn Hàng</a></li>
            <li class="nav-item"><a class="nav-link"><i class="fa fa-address-book-o"></i> Khách Hàng</a></li>
            <li class="nav-item"><a class="nav-link"><i class="fa fa-bar-chart-o"></i> Thống Kê</a></li>
            <hr>
            <li class="nav-item">
                <a href="index.php" class="nav-link" onclick="logOutAdmin(); return true;">
                    <i class="fa fa-arrow-left"></i>
                    Đăng xuất
                </a>
            </li>
        </ul>
    </aside>

    <!-- Khung hiển thị chính -->
    <div class="main">
        <div class="home">

        </div>

        <!-- Sản Phẩm -->
        <div class="sanpham">
            <table class="table-header">
                <tr>
                    <!-- Theo độ rộng của table content -->
                    <th title="Sắp xếp" style="width: 5%" onclick="sortProductsTable('stt')">Stt <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 10%" onclick="sortProductsTable('masp')">Mã <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 40%" onclick="sortProductsTable('ten')">Tên <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 15%" onclick="sortProductsTable('gia')">Giá <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 15%" onclick="sortProductsTable('khuyenmai')">Khuyến mãi <i class="fa fa-sort"></i></th>
                    <th style="width: 15%">Hành động</th>
                </tr>
            </table>

            <div class="table-content">
            </div>

            <!--<div class="table-content">
            <?php
                require_once('BackEnd/ConnectionDB/DB_classes.php');

                $sp = new SanPhamBUS();
                $i = 1;
                echo "<table class='table-outline hideImg'>";
                foreach ($sp->select_all() as $rowname => $row) {
                    echo "<tr>
                        <td style'width: 5%'>" . $i++ . "</td>
                        <td style='width: 10%'>" . $row['MaSP'] . "</td>
                        <td style='width: 40%'>
                            <a title='Xem chi tiết' target='_blank' href='chitietsanpham.php?" . $row['TenSP'] . "'>" . $row['TenSP'] . "</a>
                            <img src='" . $row['HinhAnh'] . "'></img>
                        </td>
                        <td style='width: 15%'>" . $row['DonGia'] . "</td>
                        <td style='width: 15%'>" . $row['MaKM'] . "</td>
                        <td style='width: 15%'>
                            <div class='tooltip'>
                                <i class='fa fa-wrench' onclick='addKhungSuaSanPham('" . $row['MaSP'] . "')'></i>
                                <span class='tooltiptext'>Sửa</span>
                            </div>
                            <div class='tooltip'>
                                <i class='fa fa-trash' onclick='xoaSanPham('" . $row['MaSP'] . "', '" . $row['TenSP'] . "')'></i>
                                <span class='tooltiptext'>Xóa</span>
                            </div>
                        </td>
                    </tr>";
                }
                echo "</table>";
            ?>
            </div>-->

            <div class="table-footer">
                <select name="kieuTimSanPham">
                    <option value="ma">Tìm theo mã</option>
                    <option value="ten">Tìm theo tên</option>
                </select>
                <input type="text" placeholder="Tìm kiếm..." onkeyup="timKiemSanPham(this)">
                <button onclick="document.getElementById('khungThemSanPham').style.transform = 'scale(1)'; autoMaSanPham()">
                    <i class="fa fa-plus-square"></i>
                    Thêm sản phẩm
                </button>
            </div>

            <div id="khungThemSanPham" class="overlay">
                <span class="close" onclick="this.parentElement.style.transform = 'scale(0)';">&times;</span>
                <table class="overlayTable table-outline table-content table-header">
                    <tr>
                        <th colspan="2">Thêm Sản Phẩm</th>
                    </tr>
                    <tr>
                        <td>Mã sản phẩm:</td>
                        <td><input type="text" id="maspThem"></td>
                    </tr>
                    <tr>
                        <td>Tên sản phẩm:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Hãng:</td>
                        <td>
                            <select name="chonCompany" onchange="autoMaSanPham(this.value)">
                                <script>
                                    var company = ["Apple", "Samsung", "Oppo", "Nokia", "Huawei", "Xiaomi", "Realme", "Vivo", "Philips", "Mobell", "Mobiistar", "Itel", "Coolpad", "HTC", "Motorola"];
                                    for (var c of company) {
                                        document.writeln(`<option value="` + c + `">` + c + `</option>`);
                                    }
                                </script>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Hình:</td>
                        <td>
                            <img class="hinhDaiDien" id="anhDaiDienSanPhamThem" src="">
                            <input type="file" accept="image/*" onchange="capNhatAnhSanPham(this.files, 'anhDaiDienSanPhamThem')">
                        </td>
                    </tr>
                    <tr>
                        <td>Giá tiền:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Số sao:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Đánh giá:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Khuyến mãi:</td>
                        <td>
                            <select>
                                <option value="">Không</option>
                                <option value="tragop">Trả góp</option>
                                <option value="giamgia">Giảm giá</option>
                                <option value="giareonline">Giá rẻ online</option>
                                <option value="moiramat">Mởi ra mắt</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Giá trị khuyến mãi:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <th colspan="2">Thông số kĩ thuật</th>
                    </tr>
                    <tr>
                        <td>Màn hình:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Hệ điều hành:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Camara sau:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Camara trước:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>CPU:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>RAM:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Bộ nhớ trong:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Thẻ nhớ:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Dung lượng Pin:</td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="table-footer"> <button onclick="themSanPham()">THÊM</button> </td>
                    </tr>
                </table>
            </div>
            <div id="khungSuaSanPham" class="overlay"></div>
        </div> <!-- // sanpham -->


        <!-- Đơn Hàng -->
        <div class="donhang">
            <table class="table-header">
                <tr>
                    <!-- Theo độ rộng của table content -->
                    <th title="Sắp xếp" style="width: 5%" onclick="sortDonHangTable('stt')">Stt <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 13%" onclick="sortDonHangTable('madon')">Mã đơn <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 7%" onclick="sortDonHangTable('khach')">Khách <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 20%" onclick="sortDonHangTable('sanpham')">Sản phẩm <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 15%" onclick="sortDonHangTable('tongtien')">Tổng tiền <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 10%" onclick="sortDonHangTable('ngaygio')">Ngày giờ <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 10%" onclick="sortDonHangTable('trangthai')">Trạng thái <i class="fa fa-sort"></i></th>
                    <th style="width: 10%">Hành động</th>
                </tr>
            </table>

            <div class="table-content">
            </div>

            <div class="table-footer">
                <div class="timTheoNgay">
                    Từ ngày: <input type="date" id="fromDate">
                    Đến ngày: <input type="date" id="toDate">

                    <button onclick="locDonHangTheoKhoangNgay()"><i class="fa fa-search"></i> Tìm</button>
                </div>

                <select name="kieuTimDonHang">
                    <option value="ma">Tìm theo mã đơn</option>
                    <option value="khachhang">Tìm theo tên khách hàng</option>
                    <option value="trangThai">Tìm theo trạng thái</option>
                </select>
                <input type="text" placeholder="Tìm kiếm..." onkeyup="timKiemDonHang(this)">
            </div>

        </div> <!-- // don hang -->


        <!-- Khách hàng -->
        <div class="khachhang">
            <table class="table-header">
                <tr>
                    <!-- Theo độ rộng của table content -->
                    <th title="Sắp xếp" style="width: 5%" onclick="sortKhachHangTable('stt')">Stt <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 15%" onclick="sortKhachHangTable('hoten')">Họ tên <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 20%" onclick="sortKhachHangTable('email')">Email <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 20%" onclick="sortKhachHangTable('taikhoan')">Tài khoản <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 10%" onclick="sortKhachHangTable('matkhau')">Mật khẩu <i class="fa fa-sort"></i></th>
                    <th style="width: 10%">Hành động</th>
                </tr>
            </table>

            <div class="table-content">
            </div>

            <div class="table-footer">
                <select name="kieuTimKhachHang">
                    <option value="ten">Tìm theo họ tên</option>
                    <option value="email">Tìm theo email</option>
                    <option value="taikhoan">Tìm theo tài khoản</option>
                </select>
                <input type="text" placeholder="Tìm kiếm..." onkeyup="timKiemNguoiDung(this)">
                <button onclick="openThemNguoiDung()"><i class="fa fa-plus-square"></i> Thêm người dùng</button>
            </div>
        </div> <!-- // khach hang -->

        <!-- Thống kê -->
        <div class="thongke">
            <div class="canvasContainer">
                <canvas id="myChart1"></canvas>
            </div>

            <div class="canvasContainer">
                <canvas id="myChart2"></canvas>
            </div>

            <div class="canvasContainer">
                <canvas id="myChart3"></canvas>
            </div>

            <div class="canvasContainer">
                <canvas id="myChart4"></canvas>
            </div>

        </div>
    </div> <!-- // main -->


    <footer>

    </footer>
</body>

</html>