// price
$('.price').simpleMoneyFormat();
// price

//Form Login Admin
$(document).ready(function () {
    $("#Login_admin").validate({
        rules: {
            nameadmin: {
                required: true,
            },
            passadmin: {
                required: true,
            }
        },

        messages: {
            nameadmin: {
                required: "Vui lòng nhập tên đăng nhập",
            },
            passadmin: {
                required: "Vui lòng nhập mật khẩu",
            }
        },

        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },

    });
//Form Login

//Form Thêm Sách
    $("#AddBookForm").validate({
        rules: {
            nameBook: {
                required: true,
            },
            imgBook: {
                required: true,
                extension: "png|jpg|jpeg|webp"
            },
            theloai: {
                required: true,
            },
            numBook: {
                required: true,
                number: true,
                min: 0,
            },
            priceBook: {
                required: true,
                number: true,
                min:0,
                
            }
        },

        messages: {
            nameBook: {
                required: "Vui lòng nhập tên sách",
            },
            imgBook: {
                required: "Vui lòng chọn hình sách",
                extension: "Vui lòng chọn file có dạng (png, jpeg, jpg, webp)"
            },
            theloai: {
                required: "Vui lòng chọn thể loại",
            },
            numBook: {
                required: "Vui lòng nhập số lượng sách",
                number: "Vui lòng nhập số",
                min: "Vui lòng nhập số lượng lớn hớn {0}"
            },
            priceBook: {
                required: "Vui lòng nhập giá sách",
                number: "Vui lòng nhập số",
                min:"Vui lòng nhập giá lớn hơn {0}",
            }
        },

        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        
    });
});
//Form Thêm Sách

//Form Update Sách
$(document).ready(function () {
    $('#UpdateBookForm').validate({
        rules: {
            nameBook: {
                required: true,
            },
            imgBook: {
                extension: "png|jpg|jpeg|webp"
            },
            theloai: {
                required: true,
            },
            numBook: {
                required: true,
                number: true,
                min: 0,
            },
            priceBook: {
                required: true,
                number: true,
                min:0,
                
            }

        },

        messages: {
            nameBook: {
                required: "Vui lòng nhập tên sách",
            },
            imgBook: {
                extension: "Vui lòng chọn file có dạng (png, jpeg, jpg, webp)"
            },
            theloai: {
                required: "Vui lòng chọn thể loại",
            },
            numBook: {
                required: "Vui lòng nhập số lượng sách",
                number: "Vui lòng nhập số",
                min: "Vui lòng nhập số lượng lớn hớn {0}"
            },
            priceBook: {
                required: "Vui lòng nhập giá sách",
                number: "Vui lòng nhập số",
                min:"Vui lòng nhập giá lớn hơn {0}",
            }
        },

        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },

    });
});


// $(document).ready(function () {

//     $("#UpdateBookForm").validate({
//         rules: {
//             nameBook: {
//                 required: true,
//             },
//             imgBook: {
//                 extension: "png|jpg|jpeg|webp"
//             },
//             theloai: {
//                 remote: {
//                     url: "/../project/admin/modules/checkform_admin.php",
//                     type: "post",
//                     data: {
//                         theloai: function () {
//                             return $("#theloai").val();
//                         }
//                     }
//                 }
//             },
//             numBook: {
//                 required: true,
//                 number: true,
//                 min: 0,
//             },
//             priceBook: {
//                 required: true,
//                 number: true,
//                 remote: {
//                     url: "/../project/admin/modules/checkform_admin.php",
//                     type: "post",
//                     data: {
//                         priceBook: function () {
//                             return $("#priceBook").val();
//                         }
//                     }
//                 }
//             }
//         },

//         messages: {
//             nameBook: {
//                 required: "Vui lòng nhập tên sách",
//             },
//             imgBook: {
//                 extension: "Vui lòng chọn file có dạng (png, jpeg, jpg, webp)"
//             },
//             theloai: {
//                 remote: "Vui lòng chọn thể loại",
//             },
//             numBook: {
//                 required: "Vui lòng nhập số lượng sách",
//                 number: "Vui lòng nhập số",
//                 min: "Vui lòng nhập số lượng lớn hớn {0}"
//             },
//             priceBook: {
//                 required: "Vui lòng nhập giá sách",
//                 number: "Vui lòng nhập số",
//                 remote: "Vui lòng nhập giá lớn hớn 0"
//             }
//         },

//         errorElement: "div",
//         errorPlacement: function (error, element) {
//             error.addClass("invalid-feedback");
//             error.insertAfter(element);
//         },
//         highlight: function (element, errorClass, validClass) {
//             $(element).addClass("is-invalid").removeClass("is-valid");
//         },
//         unhighlight: function (element, errorClass, validClass) {
//             $(element).addClass("is-valid").removeClass("is-invalid");
//         },
//         submitHandler: function(form){
//             form.submit();
//         }
//     });
// });
//Form Update Sách

//Form Thêm Admin
$(document).ready(function () {
    $("#addAdminForm").validate({
        rules: {
            nameadmin: {
                required: true,
                minlength: 5,
                remote: {
                    url: "../checkform_admin.php",
                    type: "post",
                    data: {
                        nameadmin: function () {
                            return $("#nameadmin").val();
                        }
                    }
                }
            },
            pass: {
                required: true,
                minlength: 5,
            },
            cfpass: {
                required: true,
                minlength: 5,
                equalTo: "#pass"
            },
        },

        messages: {
            nameadmin: {
                required: "Vui lòng nhập tên admin",
                minlength: "Tên admin phải từ 5 ký tự",
                remote: "Tên này đã được sử dụng",
            },
            pass: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải từ 5 ký tự"
            },
            cfpass: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải từ 5 ký tự",
                equalTo: "Mật khẩu đã nhập không khớp với mật khẩu trên"

            },
        },

        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
    });
});
//Form Thêm Admin

//Form Thêm Thể Loại
$(document).ready(function () {
    $("#AddTLForm").validate({
        rules: {
            nameTheLoai: {
                required: true,
                remote: {
                    url: "/../project/admin/modules/checkform_admin.php",
                    type: "post",
                    data: {
                        nameTheLoai: function () {
                            return $("#nameTheLoai").val();
                        }
                    }
                }
            },

        },

        messages: {
            nameTheLoai: {
                required: "Vui lòng nhập thể loại",
                remote: "Thể loại này đã tồn tại",
            },

        },

        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },

    });
});
//Form Thêm Thể Loại


