<!-- Jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Boostrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
<script src="../../js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
<!-- SimpleMoneyFormat -->
<script src="/../project/js/simple.money.format.js"></script>
<!-- DataTable -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- JS validate -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<!-- Myjs -->
<script src="/../project/admin/js/admin.js?<?= time() ?>"></script>

<script>
    $(document).ready(function() {
        $('.actived').addClass("bg-primary text-white");
    });
</script>

<script>
    $('#datatable').DataTable({
        lengthMenu: [
            [10, 20, 30, 40, -1],
            [10, 20, 30, 40, 'All']
        ]
    });
    $('#orders').DataTable({
        lengthMenu: [
            [10, 20, 30, 40, -1],
            [10, 20, 30, 40, 'All']
        ],
        order: [[0, 'desc']]
    });
    $('#sidebar').DataTable({
        "lengthChange": false,
        "bInfo" : false,
        "bPaginate": false,
    });

    //menu admin
    $(document).ready(function() {
        $("#menu-toggle").on('click', function() {
            $("#wrapper").toggleClass("toggled");
        });
    });
</script>
<script src="/../project/admin/js/chat.js?<?= time() ?>"></script>
</body>

</html>