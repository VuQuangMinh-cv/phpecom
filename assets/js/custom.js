$(document).ready(function(){

    // Xử lý tăng số lượng sản phẩm
    $(document).on('click','.increment-btn', function (e){
        e.preventDefault();

        var qty = $(this).closest('.product_data').find('.input-qty').val();
        var value = parseInt(qty, 10);
        value = isNaN(value) ? 0 : value;
        if(value < 10)
        {
            value++;
            $(this).closest('.product_data').find('.input-qty').val(value);
        }
    });

    // Xử lý giảm số lượng sản phẩm
    $(document).on('click','.decrement-btn', function (e){
        e.preventDefault();

        var qty = $(this).closest('.product_data').find('.input-qty').val();
        var value = parseInt(qty, 10);
        value = isNaN(value) ? 0 : value;
        if(value > 1)
        {
            value--;
            $(this).closest('.product_data').find('.input-qty').val(value);
        }
    });

    // Thêm sản phẩm vào giỏ hàng
    $(document).on('click','.addToCartBtn', function (e){
        e.preventDefault();

        var qty = $(this).closest('.product_data').find('.input-qty').val();
        var prod_id = $(this).val();
        
        $.ajax({
            method: "POST",
            url: "functions/handlecart.php",
            data: {
              'prod_id':prod_id,
              'prod_qty':qty,
              'scope': 'add'
            },
            success: function(response){
                if(response == 201)
                    {
                        alertify.success('Product added to cart');
                    }
                else if(response == "existing")
                    {
                        alertify.success('Product already in cart');
                    }
                else if(response == 401)
                    {
                        alertify.success('Login to continue');
                    }
                else if(response == 500)
                    {
                        alertify.success('Something went wrong');
                    }
            }
        });
    });

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    $(document).on('click','.updateQty', function (){
        var qty = $(this).closest('.product_data').find('.input-qty').val();
        var prod_id = $(this).closest('.product_data').find('.prodId').val();

        $.ajax({
            method: "POST",
            url: "functions/handlecart.php",
            data: {
              'prod_id':prod_id,
              'prod_qty':qty,
              'scope': 'update'
            },
            success: function(response){
                // alert(response);
            }
        });
    });
    
    // Xóa sản phẩm khỏi giỏ hàng
    $(document).on('click','.deleteItem', function (){
        var cart_id = $(this).val();

        $.ajax({
            method: "POST",
            url: "functions/handlecart.php",
            data: {
              'cart_id': cart_id,
              'scope': 'delete'
            },
            success: function(response){
                if(response == 200)
                    {
                        alertify.success('Item deleted successfully');
                        $('#mycart').load(location.href +" #mycart");
                    }
                    else{
                        alertify.error(response);
                    }
            }
        });
    });

    // Xử lý gửi OTP
    document.getElementById('send-otp-btn').addEventListener('click', function() {
        const email = document.querySelector('input[name="email"]').value;
        if (!email) {
            alert('Vui lòng nhập email trước khi gửi OTP.');
            return;
        }

        fetch('functions/send_otp.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('otp-info').textContent = 'Mã OTP đã được gửi đến email của bạn. Vui lòng kiểm tra.';
            } else {
                document.getElementById('otp-info').textContent = 'Có lỗi xảy ra khi gửi OTP. Vui lòng thử lại.';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('otp-info').textContent = 'Có lỗi xảy ra. Vui lòng thử lại.';
        });
    });

});
