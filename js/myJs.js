// simpleMoneyFormat 
$('.price').simpleMoneyFormat();
// simpleMoneyFormat

// rateyo
$(function () {
    $(".rateyo").rateYo().on("rateyo.change", function (e, data) {
        var rating = data.rating;
        $(this).parent().find('.score').text('score :' + $(this).attr('data-rateyo-score'));
        $(this).parent().find('.result').text('rating :' + rating);
        $(this).parent().find('.rating').val(rating);
    });
});
// rateyo


//oWl-carousel
const prev = '<img class="img-left-arrow" src="images/left.png">';
const next = '<img class="img-right-arrow" src="images/right.png">';

$('.owl-carousel').owlCarousel({
    autoplay: true,
    autoplayTimeout: 2000,
    autoplayHoverPause: true,
    loop: true,
    margin: 10,
    nav: true,
    navText: [
        prev,
        next
    ],
    stageClass: 'owl-stage d-flex',
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 3
        },
        1000: {
            items: 5
        }
    }
})
//oWl-carousel


//Form Register
$(document).ready(function () {
    $("#signupForm").validate({
        rules: {
            fullname: {
                required: true,
                remote: {
                    url: "checkform.php",
                    type: "post",
                    data: {
                        fullname: function () {
                            return $("#fullname").val();
                        }
                    }
                }
            },
            sdt: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number: true,
                remote: {
                    url: "checkform.php",
                    type: "post",
                    data: {
                        sdt: function () {
                            return $("#sdt").val();
                        }
                    }
                }
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: "checkform.php",
                    type: "post",
                    data: {
                        email: function () {
                            return $("#email").val();
                        }
                    }
                }
            },
            password: {
                required: true,
                minlength: 8
            },
            cf_password: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
            avatar: {
                required: true,
                extension: "png|jpg|jpeg|webp"
            }
        },

        messages: {
            fullname: {
                required: "Vui lòng nhập vào tên đầy đủ của bạn",
                remote: "Tên này đã được sử dụng"
            },
            sdt: {
                required: "Vui lòng nhập vào số điện thoại của bạn",
                minlength: "Số điện thoại phải đủ {0} số",
                maxlength: "Số điện thoại phải đủ {0} số",
                number: "Số điện thoại phải là số",
                remote: "Số điện thoại này đã được sử dụng"
            },
            password: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải có ít nhất {0} ký tự"
            },
            cf_password: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải có ít nhất {0} ký tự",
                equalTo: "Mật khẩu không trùng khớp với mật khẩu đã nhập"
            },
            email: {
                required: "Vui lòng nhập địa chỉ email",
                email: "Địa chỉ Email không hợp lệ",
                remote: "Địa chỉ Email này đã được sử dụng"
            },
            avatar: {
                required: "Vui lòng chọn hình",
                extension: "Vui lòng chọn file có dạng (png, jpeg, jpg, webp)",
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
//Form Register

// My Account Form
$(document).ready(function () {
    $('#myAccountForm').validate({
        rules: {
            avatar: {
                extension: "png|jpg|jpeg|webp"
            }

        },
        messages: {
            avatar: {
                extension: "Vui lòng chọn file có dạng (png, jpeg, jpg, webp)"
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
    })
})
// My Account Form

// Change Infor Form
$(document).ready(function () {
    $('#changeInforForm').validate({
        rules: {
            fullname: {
                required: true,
                // remote: {
                //     url: "checkform.php",
                //     type: "post",
                //     data: {
                //         fullname: function () {
                //             return $("#fullname").val();
                //         }
                //     }
                // }
            },
            sdt: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10,
                // remote: {
                //     url: "checkform.php",
                //     type: "post",
                //     data: {
                //         sdt: function () {
                //             return $("#sdt").val();
                //         }
                //     }
                // }
            },
            email: {
                required: true,
                email: true,
                // remote: {
                //     url: "checkform.php",
                //     type: "post",
                //     data: {
                //         email: function () {
                //             return $("#email").val();
                //         }
                //     }
                // }
            }

        },
        messages: {
            fullname: {
                required: "Vui lòng nhập tên đầy đủ của bạn",
                remote: "Tên này đã được sử dụng",
            },
            sdt: {
                required: "Vui lòng nhập số điện thoại",
                number: "Số điện thoại sai",
                minlength: "Số điện thoại phải đủ {0} số",
                maxlength: "Số điện thoại phải đủ {0} số",
                remote: "Số điện thoại này đã được sử dụng",
            },
            email: {
                required: "Vui lòng nhập địa chỉ email",
                email: "Địa chỉ email sai",
                remote: "Email này đã được sử dụng",
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
    })
})
// Change Infor Form

//Form ChangePass
$(document).ready(function () {
    $("#ChangePassForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            oldpass: {
                required: true,
                minlength: 8
            },
            newpass: {
                required: true,
                minlength: 8,
            },
            cfnewpass: {
                required: true,
                minlength: 8,
                equalTo: "#newpass"
            },
        },

        messages: {
            oldpass: {
                required: "Vui lòng nhập mật khẩu cũ",
                minlength: "Mật khẩu phải có ít nhất {0} ký tự",
            },
            newpass: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải có ít nhất {0} ký tự",
            },
            cfnewpass: {
                required: "Vui lòng nhập lại mật khẩu",
                minlength: "Mật khẩu phải có ít nhất {0} ký tự",
                equalTo: "Mật khẩu không trùng khớp với mật khẩu mới"
            },
            email: {
                required: "Vui lòng nhập địa chỉ Email",
                email: "Địa chỉ Email không hợp lệ"
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
//Form ChangePass

//Form checkout
$(document).ready(function () {
    $("#checkoutForm").validate({
        rules: {
            dcgh: {
                required: true,
            },

        },

        messages: {
            dcgh: {
                required: "Vui lòng thêm địa chỉ ở mục: TÀI KHOẢN CỦA TÔI -> ĐỊA CHỈ GIAO HÀNG",
            }
        },

        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            if (element.prop("type") === "radio") {
                error.insertAfter(element.siblings("label"));
            }
            else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
    });
});
//Form checkout


//Form Login
$(document).ready(function () {
    $("#LoginForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8
            }
        },

        messages: {
            email: {
                required: "Vui lòng nhập địa chỉ Email",
                email: "Địa chỉ Email không hợp lệ"
            },
            password: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải có ít nhất {0} ký tự"
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
//Form Login



//Form Forgot
$(document).ready(function () {
    $("#ForgotForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },

        messages: {
            email: {
                required: "Vui lòng nhập địa chỉ Email",
                email: "Địa chỉ Email không hợp lệ"
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
//Form Forgot



// Thêm địa chỉ giao hàng
$(document).ready(function () {
    $('#tinh').on('change', function () {
        var tinh = $(this).val();
        // console.log(tinh);
        if (tinh) {
            // If a province is selected, fetch the quan_huyen for that province using AJAX
            $.ajax({
                url: 'checkform.php',
                method: 'GET',
                dataType: "json",
                data: {
                    tinh: tinh
                },
                success: function (data) {
                    // Clear the current options in the "quan_huyen" select box
                    $('#quan_huyen').empty();

                    // Add the new options for the quan_huyen for the selected province
                    $.each(data, function (i, quan_huyen) {
                        // console.log(quan_huyen);
                        $('#quan_huyen').append($('<option>', {
                            value: quan_huyen.id,
                            text: quan_huyen.name
                        }));
                    });
                    // Clear the options in the "wards" select box
                    $('#xa').val(null);
                    // $('#xa').append($('<option>', {
                    //     value: "",
                    //     text: "Chọn một Xã/phường"
                    // }));
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }

            });
            //$('#xa').val(null);
        } else {
            // If no province is selected, clear the options in the "district" and "wards" select boxes
            $('#quan_huyen').val(null);
        }
    });

    $('#quan_huyen').on('change', function () {
        var quan_huyen = $(this).val();
        // console.log(quan_huyen);
        if (quan_huyen) {
            // If a district is selected, fetch the awards for that district using AJAX
            $.ajax({
                url: 'checkform.php',
                method: 'GET',
                dataType: "json",
                data: {
                    quan_huyen: quan_huyen
                },
                success: function (data) {
                    // console.log(data);
                    // Clear the current options in the "wards" select box
                    $('#xa').empty();
                    // Add the new options for the awards for the selected district
                    $.each(data, function (i, xa) {
                        $('#xa').append($('<option>', {
                            value: xa.id,
                            text: xa.name
                        }));
                    });
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }
            });
        } else {
            // If no district is selected, clear the options in the "award" select box
            $('#xa').val(null);
        }
    });
});

// Thêm địa chỉ giao hàng



//Actived menu
$(document).ready(function () {
    $('.actived').css("border-bottom", "3px solid #000");
});
//Actived menu

// chat
function chat_validation() {
    const textmsg = $('#typing').val();
    const receiver_id = $('#receiver_id').val();
    const sender_id = $('#sender_id').val();

    if (textmsg == '') {
        alert("Nhập để chat");
        return false;
    }
    const datastr = 'message=' + textmsg + '&receiver_id=' + receiver_id + '&sender_id=' + sender_id;

    $.ajax({
        url: './chat_user/chatlog.php',
        type: 'post',
        data: datastr,
        success: function (e) {
            $('#msg').html(e);
        }
    });
    document.getElementById('typing-sending').reset();
    return false;
}

$(document).ready(function () {
    $('#open_chat').on('click', function () {
        $('#chat-popup').css('display', 'block');
        $(this).css('display', 'none');
    })
});

$(document).ready(function () {
    $('#close_chat').on('click', function () {
        $('#chat-popup').css('display', 'none');
        $('#open_chat').css('display', 'block')
    })
});



// chat

