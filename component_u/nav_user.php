<!-- Navbar -->
<div class="sticky-top z-2">
    <div id="nav">
        <nav class="navbar bg-info justify-content-center">
            <nav class="navbar navbar-expand-sm">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar ">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" tabindex="-1" id="collapsibleNavbar">
                        <ul class="navbar-nav ">
                            <li class="nav-item">
                                <a class="nav-link me-5 text-dark fw-bold <?php if ($page == 'Trang chủ') echo 'actived'; ?>" href="/../project/home.php">TRANG CHỦ </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-5 text-dark fw-bold <?php if ($page == 'Tất cả sách' || $page=='Tìm kiếm' || $page=='Thông tin chi tiết') echo 'actived'; ?>" href="/../project/xuly.php?action=allsp"> TẤT CẢ SÁCH </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-5 text-dark fw-bold " href="#">GIỚI THIỆU</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-5 text-dark fw-bold " href="#"> LIÊN HỆ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-5 text-dark fw-bold <?php if ($page == 'Giỏ hàng') echo 'actived'; ?>" href="/../project/cart.php"> GIỎ HÀNG</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-dark fw-bold <?php if ($page == 'theloai') echo 'actived'; ?>" role="button" data-bs-toggle="dropdown">THỂ LOẠI </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?php
                                        $sql_tl = $conn->prepare("SELECT * FROM `theloaisach`");
                                        $sql_tl->execute();
                                        while ($row_tl = $sql_tl->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <a class="dropdown-item" href="xuly.php?idtl=<?= $row_tl['idTheLoai'];  ?>"><?= $row_tl['tenTheLoai'] ?></a>
                                        <?php
                                        }
                                        ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </nav>
    </div>
</div>
<!-- Navbar -->