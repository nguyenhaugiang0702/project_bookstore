<div id="footer" class="bg-info p-5">
    <div class="container-fluid mx-3 row">
        <div class="col-sm-2 mb-5">
            <img id="logo_footer" src="images/logo.jpg" alt="">
            <h4 class="text-dark mt-4">Website bán sách số 1 Việt Nam</h4>
        </div>

        <div class="col-sm-3 text-dark mb-5">
            <h5 class="mb-4">Thông tin liên hệ</h5>
            <hr class="text-dark">
            <p><i class="fa-solid fa-phone fs-5"></i> : 038484407</p>
            <p><i class="fa-solid fa-location-dot fs-5"></i> : Khu II, Đ. 3 Tháng 2, Xuân Khánh, Ninh Kiều, Cần Thơ</p>
            <p><i class="fa-solid fa-envelope fs-5"></i> : bookstore112233@gmail.com</p>
            <a href="#" class="text-decoration-none">
                <i class="fa-brands fa-facebook fs-3 icon_footer_contact"></i>
            </a>
            <a href="#" class="text-decoration-none">
                <i class="fa-brands fa-youtube ms-3 fs-3 icon_footer_contact"></i>
            </a>
            <a href="#" class="text-decoration-none">
                <i class="fa-brands fa-twitter ms-3 fs-3 icon_footer_contact"></i>
            </a>
        </div>

        <div class="col-sm-2 text-dark mb-5">
            <h5 class="mb-4">Chính sách bán hàng</h5>
            <hr class="text-dark ">
            <ul class="list-unstyled">
                <li>
                    <p>Hướng dẫn mua hàng</p>
                </li>
                <li>
                    <p>Hướng dẫn thanh toán</p>
                </li>
                <li>
                    <p>Chính sách vận chuyển</p>
                </li>
                <li>
                    <p>Điều khoản dịch vụ</p>
                </li>
                <li>
                    <p>Chính sách bảo mật</p>
                </li>
                <li>
                    <p>Chính sách đổi trả</p>
                </li>
            </ul>
        </div>

        <div class="col-sm-2 text-dark mb-5">
            <h5 class="mb-4">Hỗ trợ khách hàng</h5>
            <hr class="text-dark ">
            <ul class="list-unstyled">
                <li>
                    <p>Trang chủ</p>
                </li>
                <li>
                    <p>Giới thiệu</p>
                </li>
                <li>
                    <p>Danh mục</p>
                </li>
                <li>
                    <p>Tin tức</p>
                </li>
                <li>
                    <p>Liên hệ</p>
                </li>
            </ul>
        </div>

        <div class="col-sm-2 text-dark">
            <h5 class="mb-4">Bản đồ</h5>
            <hr class="text-dark ">
            <div id="map">
                <iframe class="col-12 col-md-9" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d245.55804535365044!2d105.76820174754104!3d10.02274050793034!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1675434954291!5m2!1svi!2s" style="border:0; width: 250px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    <div class=" container-fluid text-dark text-center mx-auto">
        <hr class="text-dark">
        <span>&copy 2023 My Website</span>
        <a href="#top" class="text-decoration-none"><i class="fa-solid fa-arrow-up icon_footer_backTop fs-2"></i></a>
    </div>
    <button id="open_chat" class="bg-primary text-white z-1">
        Chat
        <div id="notification" class="z-2" style="position: relative; top: -35px; left: 5px;"></div>
    </button>
    <div onload="return load_notification()"></div>

    <?php include './chat_user/chat.php'; ?>
</div>

<!-- Jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Boostrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Rateyo Đánh giá -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<!-- Carousel -->
<script src="./js/owl.carousel.min.js"></script>
<!-- simpleMoneyFormat -->
<script src="./js/simple.money.format.js"></script>
<!-- Jquey validate Form -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<!-- Jquey UI Range -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    // Jquey UI Range
    $(function() {
        $("#slider-range").slider({
            orientation: "horizontal",
            range: true,
            min: <?= $_SESSION['min'] ?>,
            max: <?= $_SESSION['max'] ?>,
            step: 10000,
            values: [<?= $_SESSION['min'] ?>, <?= $_SESSION['max'] ?>],
            slide: function(event, ui) {
                $("#amount").val(ui.values[0]).simpleMoneyFormat();
                $("#amount_end").val(ui.values[1]).simpleMoneyFormat();
                $("#start_price").val(ui.values[0]);
                $("#end_price").val(ui.values[1]);
            }
        });
        $("#amount").val($("#slider-range").slider("values", 0)).simpleMoneyFormat();
        $("#amount_end").val($("#slider-range").slider("values", 1)).simpleMoneyFormat();
    })
    // Jquey UI Range
</script>
<script>
    $(document).ready(function mess() {
        const receiver_id = $('#receiver_id').val();
        const sender_id = $('#sender_id').val();
        const datastr = 'receiver_id=' + receiver_id + '&sender_id=' + sender_id;
        setInterval(function() {
            $.ajax({
                url: './chat_user/chat_loader.php',
                type: 'get',
                data: datastr,
                success: function(e) {
                    $('#chat_load').html(e);
                }
            });
        }, 1000)
    });

    $(document).ready(function load_notification() {
        setInterval(function() {
            $.ajax({
                url: './chat_user/load_notification.php',
                success: function(e) {
                    $('#notification').html(e);
                }
            });
        }, 500)
    });
</script>

<!-- myJs -->
<script src="./js/myJs.js?<?= time() ?>"></script>
</body>

</html>