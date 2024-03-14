    <div class="bg-white border-end" id="sidebar-wrapper">
        <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i class="fas fa-user-secret me-2"></i>BOOKSTORE</div>
        <div class="list-group list-group-flush my-3">
            <div class="hover_sidebar bg-gradient  <?php if ($page == 'Trang chủ') {
                                                        echo 'actived';
                                                    } ?>">
                <a href="/../project/admin/admin.php" class="list-group-item list-group-item-action bg-transparent fw-bold">
                    <span class="<?php if ($page == 'Trang chủ') {
                                        echo 'actived';
                                    } ?>"><i class="fas fa-tachometer-alt me-2"></i>Trang chủ</span>
                </a>
            </div>
            <div class="hover_sidebar bg-gradient <?php if ($page == 'Sách' || $page == 'Sửa Sách' || $page == 'Thêm Sách') {
                                                        echo 'actived';
                                                    } ?>">
                <a href="/../project/admin/modules/quanlySach/lietke.php" class="list-group-item list-group-item-action bg-transparent fw-bold ">
                    <span class="<?php if ($page == 'Sách' || $page == 'Sửa Sách' || $page == 'Thêm Sách') {
                                        echo 'actived';
                                    } ?>"><i class="fa-solid fa-book me-2"></i>Sách</span>
                </a>
            </div>
            <div class="hover_sidebar bg-gradient <?php if ($page == 'Thể Loại') {
                                                        echo 'actived';
                                                    } ?>">
                <a href="/../project/admin/modules/quanlyTheLoai/lietke_theloai.php" class="list-group-item list-group-item-action bg-transparent fw-bold">
                    <span class="<?php if ($page == 'Thể Loại') {
                                        echo 'actived';
                                    } ?>"><i class="fa-solid fa-list me-2"></i>Thể Loại</span>
                </a>
            </div>
            <div class="hover_sidebar bg-gradient <?php if ($page == 'Đơn Hàng') {
                                                        echo 'actived';
                                                    } ?>">
                <a href="/../project/admin/modules/quanlyOrder/lietke_donhang.php" class="list-group-item list-group-item-action bg-transparent fw-bold">
                    <span class="<?php if ($page == 'Đơn Hàng') {
                                        echo 'actived';
                                    } ?>"><i class="fas fa-shopping-cart me-2"></i>Đơn Hàng</span>
                </a>
            </div>
            <div class="hover_sidebar bg-gradient <?php if ($page == 'Người Dùng') {
                                                        echo 'actived';
                                                    } ?>">
                <a href="/../project/admin/modules/quanlyUsers/lietke_user.php" class="list-group-item list-group-item-action bg-transparent fw-bold">
                    <span class="<?php if ($page == 'Người Dùng') {
                                        echo 'actived';
                                    } ?>"><i class="fa-solid fa-user me-2"></i></i>Người Dùng</span>
                </a>
            </div>
            <div class="hover_sidebar bg-gradient <?php if ($page == 'Bình Luận') {
                                                        echo 'actived';
                                                    } ?>">
                <a href="/../project/admin/modules/quanlyComment/lietke_cmt.php" class="list-group-item list-group-item-action bg-transparent fw-bold">
                    <span class="<?php if ($page == 'Bình Luận') {
                                        echo 'actived';
                                    } ?>"><i class="fas fa-comment-dots me-2"></i>Bình Luận</span>
                </a>
            </div>
            <div class="hover_sidebar bg-gradient <?php if ($page=='Phân Quyền') {
                                                        echo 'actived';
                                                    } ?>">
                <a href="/../project/admin/modules/phanquyenAdmin/lietke_admin.php" class="list-group-item list-group-item-action 
                                            bg-transparent fw-bold">
                    <span class="<?php if ($page=='Phân Quyền') {
                                        echo 'actived';
                                    } ?>"><i class="fa-solid fa-users me-2"></i>Phân Quyền</span>
                </a>
            </div>
            <div class="hover_sidebar bg-gradient <?php if ($page=='Chat') {
                                                        echo 'actived';
                                                    } ?>">
                <a href="/../project/admin/modules/chat/lietke_chat.php" class="list-group-item list-group-item-action 
                                            bg-transparent fw-bold">
                    <span class="<?php if ($page=='Chat') {
                                        echo 'actived';
                                    } ?>"><i class="fa-brands fa-rocketchat me-2"></i>Chat</span>
                </a>
            </div>
            <div class="hover_sidebar bg-gradient">
                <a href="/../project/admin/modules/component_ad/logout_admin.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold">
                    <span class=""><i class="fas fa-power-off me-2"></i>Logout</span>
                </a>
            </div>
        </div>
    </div>