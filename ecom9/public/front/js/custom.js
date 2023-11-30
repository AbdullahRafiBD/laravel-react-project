$(document).ready(function(){
    // alert('test');
    $('#getPrice').change(function(){
        var size = $(this).val();
        var product_id = $(this).attr('product-id');
        // alert(size);
        // alert(product_id);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url:'/get-product-price',
            data:{size:size,product_id:product_id},
            type:'post',
            success: function(resp){
                // alert(resp['final_price']);
                // alert(resp['discount']);
                if (resp['discount']>0) {
                    $(".getAttributePrice").html("<div class='price'><h4>$"+resp['final_price']+"</h4></div><div class='original-price'><span>Original Price:</span><span>$ "+resp['product_price']+"</span></div>");
                } else {
                    $(".getAttributePrice").html("<div class='price'><h4>$"+resp['final_price']+"</h4></div>");
                }
            },error: function () {
                alert("Error");
            },
        });
    });


    // Update Cart Items Quantity
    $(document).on('click','.updateCartItem',function(){
        // alert('test');
        if ($(this).hasClass('plus-a')) {
            // Get Quantity
            var quantity = $(this).data('qty');
            // alert(quantity);
            // Increase the Quantity by 1
            new_qty = parseInt(quantity)+1;
            // alert(new_qty);
        }

        if ($(this).hasClass('minus-a')) {
            // Get Quantity
            var quantity = $(this).data('qty');
            // alert(quantity);
            // Check Quantity is Atleast 1
            if (quantity<=1) {
                alert('item Quantity must be 1 or Greater!');
                return false;
            }
            // Increase the Quantity by 1
            new_qty = parseInt(quantity)-1;
            // alert(new_qty);
        }
        var cartid = $(this).data('cartid');
        // alert(cartid);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data:{cartid:cartid,qty:new_qty},
            url:'/cart/update',
            type:'post',
            success:function(resp){
                // alert(resp);
                if (resp.status==false) {
                    alert(resp.message);
                }
                $('#appendCartItems').html(resp.view);
            },error: function(){
                alert('error');
            }
        });
    });


    // Delete Cart Items
    $(document).on('click','.deleteCartItem',function(){
        var cartid = $(this).data('cartid');
        // alert(cartId);
        // var result = confirm('Are you sure remove item from cart?')
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data:{cartid:cartid},
            url:'/cart/delete',
            type:'post',
            success:function(resp){
                // alert(resp);
                $('#appendCartItems').html(resp.view);
            },error: function(){
                alert('error');
            }
        })

    });


    // Register Form and Validation
    $('#registerForm').submit(function(){
        $(".loader").show(); // Loader code
        var formdata = $(this).serialize();
        // alert (formdata);
        // return false;
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url:'/user/register',
            type:'POST',
            data:formdata,
            success:function(resp){
                // alert(resp);
                // alert(resp.type);
                if (resp.type=='error') {
                    $(".loader").hide(); // Loader code
                    $.each(resp.errors,function(i,error){
                        $('#register-'+i).attr('style','color:red');
                        $('#register-'+i).html(error);

                        setTimeout(function(){
                        $('#register-'+i).css({'display':'none'});
                    },5000)
                    })

                } else if(resp.type=='success') {
                    // alert(resp.message);
                    $(".loader").hide(); // Loader code

                    $('#register-success').attr('style','color:green');
                    $('#register-success').html(resp.message);
                    // window.location.href = resp.url;
                }

            },error: function(){
                alert('error');
            }
        })
    });



    // Login Form and Validation
    $('#loginForm').submit(function(){
        var formdata = $(this).serialize();
        // alert (formdata);
        // return false;
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url:'/user/login',
            type:'POST',
            data:formdata,
            success:function(resp){
                // alert(resp);
                // alert(resp.type);
                if (resp.type=='error') {
                    $.each(resp.errors,function(i,error){
                        $('#login-'+i).attr('style','color:red');
                        $('#login-'+i).html(error);

                        setTimeout(function(){
                        $('#login-'+i).css({'display':'none'});
                    },5000)
                    })

                } else if(resp.type=='incorrect') {
                    // alert(resp.message);
                    $('#login-error').attr('style','color:red');
                        $('#login-error').html(resp.message);
                }else if(resp.type=='success') {
                    window.location.href = resp.url;
                }
            },error: function(){
                alert('error');
            }
        })
    });

});

// $(document).ready(function(){
//     $('#sort').on("change",function(){
//         // this.form.submit();
//         var sort = $('#sort').val();
//         // alert(sort); return false;
//         var url = $('#url').val();
//         // alert(url); return false;
//         var fabric = get_filter("fabric");
//         $.ajax({
//             headers: {
//                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//             },
//             url: url,
//             method: "Post",
//             data: { sort: sort, url: url, fabric: fabric },
//             success: function (data) {
//                 $(".filter_products").html(data);
//             },
//             error: function () {
//                 alert("Error");
//             },
//         });
//     });
// });


// $('.fabric').on('click',function(){
//     var url = $("#url").val();
//     var sort = $("#sort option:selected").val();
//     var fabric = get_filter('fabric');
//     $.ajax({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         },
//         url: url,
//         method: "post",
//         data: { url: url, sort: sort, fabric: fabric },
//         success: function (data) {
//             $(".filter_products").html(data);
//         },
//         error: function () {
//             alert("Error");
//         },
//     });
// });


function get_filter(class_name){
    var filter = [];
    $('.' + class_name+':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}
