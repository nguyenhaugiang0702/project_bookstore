    <div class="bg-primary">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left text-white fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0 text-white">
                    <?php
                        if (isset($page)) echo $page; 
                    ?>
                </h2>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon "></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-bold" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-bell"></i>
                            <span class="position-absolute top-20 start-70 translate-middle badge rounded-pill bg-danger">
                                <?php
                                require '../../../config/connect.php';
                                $flag = 0;
                                $select_donhang = $conn->prepare("SELECT * FROM `orders` WHERE status_order=5 OR status_order=1");
                                $select_donhang->execute();
                                $select_slSach = $conn->prepare("SELECT idSach,soLuong FROM `sach`");
                                $select_slSach->execute();
                                if ($select_donhang->rowCount() > 0) {
                                    $flag = 1;
                                    if ($select_slSach->rowCount() > 0) {
                                        while ($row_slSach = $select_slSach->fetch(PDO::FETCH_ASSOC)) {
                                            if ($row_slSach['soLuong'] == 0) {
                                                $flag = 2;
                                                break;
                                            }
                                        }
                                    }
                                }
                                echo $flag;
                                ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php
                            if ($select_donhang->rowCount() == 0) {
                                echo ' <li>
                        <a class="dropdown-item text-decoration-none">Chưa có thông báo</a>
                    </li>';
                            } else {
                                echo '<li>
                            <a class="dropdown-item text-decoration-none" href="/../project/admin/modules/quanlyOrder/lietke_donhang.php">Thông báo về đơn hàng</a>
                        </li>';
                                if ($flag == 2) {
                                    echo '<li>
                            <a class="dropdown-item text-decoration-none" href="/../project/admin/modules/quanlySach/lietke.php">Số lượng sách hết </a>
                        </li>';
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i><?php if (isset($_SESSION['admin_name'])) echo $_SESSION['admin_name']; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/../project/admin/modules/component_ad/logout_admin.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>