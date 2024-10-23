<?php 
include('functions/userfunctions.php');
include("includes/header.php");
include("authenticate.php");

// Đảm bảo người dùng đã đăng nhập
if (isset($_SESSION['auth_user'])) {
    $user_email = $_SESSION['auth_user']['email'];
} else {
    $_SESSION['message'] = "Bạn cần đăng nhập để thanh toán";
    header('Location: login.php');
    exit();
}

// Kiểm tra xác thực OTP
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    $_SESSION['message'] = "Bạn cần xác thực OTP trước khi thanh toán.";
    header('Location: verify_otp_form.php');
    exit();
}

$page = basename($_SERVER["SCRIPT_NAME"]);

function encrypt($plaintext, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($plaintext, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

$key = '03589670970978681922034202007380'; // Khóa mã hóa

?>

<div class="py-3 bg-primary">
    <div class="container">
        <h6 class="text-white">
            <a class="text-white" href="index.php">Home /</a>
            <a class="text-white" href="checkout.php">Checkout</a>
        </h6>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="card">
            <div class="card-body shadow">
                <form id="payment-form" action="functions/placeorder.php" method="POST">
                    <div class="row">
                        <div class="col-md-7">
                            <h5>Basic Details</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold">Name</label>
                                    <input type="text" name="name" class="form-control" required placeholder="Enter your name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold">E-mail</label>
                                    <input type="email" name="email" value="<?= htmlspecialchars($user_email) ?>" class="form-control" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold">Phone</label>
                                    <input type="text" name="phone" class="form-control" required placeholder="Enter your Phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold">Pin Code</label>
                                    <input type="text" name="pincode" class="form-control" required placeholder="Enter your Pin Code">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="fw-bold">Address</label>
                                    <textarea required name="address" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h5>Order Details</h5>
                            <hr>
                            <?php 
                            $items = getCartItems();
                            $totalPrice = 0;
                            foreach($items as $citem) {
                                ?>
                                <div class="mb-1 border">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <img src="uploads/<?= htmlspecialchars($citem['image']) ?>" alt="Image" width="80px">
                                        </div>
                                        <div class="col-md-5">
                                            <label><?= htmlspecialchars($citem['name']) ?></label>
                                        </div>
                                        <div class="col-md-3">
                                            <label><?= number_format($citem['selling_price'], 0, '', ',') ?> VND</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label>x <?= htmlspecialchars($citem['prod_qty']) ?></label>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                $totalPrice += $citem['selling_price'] * $citem['prod_qty']; 
                            }
                            ?>
                            <hr>
                            <h5>Total Price: <span class="float-end fw-bold"><?= number_format($totalPrice, 0, '', ',') ?> VND</span></h5>
                            <div class="mt-4">
                                <input type="hidden" name="payment_mode" value="COD">
                                <input type="hidden" name="totalPrice" value="<?= htmlspecialchars($totalPrice) ?>"> <!-- Thêm trường này -->
                                <button type="submit" name="placeOrderBtn" class="btn btn-primary w-100 mb-3">Confirm and place order | COD</button>
                                <button type="button" onclick="window.location.href='momo_payment.php';" class="btn btn-success w-100 mb-3">
                                <i class="fa fa-qrcode" aria-hidden="true" style="margin-right: 10px;"></i>Thanh toán qua MoMo QRcode</button>
                                <button type="button" onclick="window.location.href='momo_atm_payment.php';" class="btn btn-danger w-100 mb-3">Thanh toán qua MoMo ATM</button>

                                <hr>
                                <div id="paypal-button-container"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php") ?>

<script src="https://www.paypal.com/sdk/js?client-id=AdmjjPCIh1OAjkAPx0PmG5sBghIDkbSpbmXkCnDXn8nQl3rkoNscVzC6LTNc_7vudWPev_zQCT8I2qEx&currency=USD"></script>

<script>
    function convertVNDToUSD(vnd) {
        const exchangeRate = 23000; 
        return (vnd / exchangeRate).toFixed(2);
    }

    const totalPriceVND = <?= json_encode($totalPrice) ?>;
    const totalPriceUSD = convertVNDToUSD(totalPriceVND);

    paypal.Buttons({
        style: {
            shape: 'rect',
            layout: 'vertical',
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        currency_code: 'USD',
                        value: totalPriceUSD
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'functions/placeorder.php';

                const fields = {
                    name: document.querySelector('input[name="name"]').value,
                    email: document.querySelector('input[name="email"]').value,
                    phone: document.querySelector('input[name="phone"]').value,
                    pincode: document.querySelector('input[name="pincode"]').value,
                    address: document.querySelector('textarea[name="address"]').value,
                    payment_mode: 'PayPal',
                    payment_id: details.id // PayPal Order ID
                };

                // Mã hóa số điện thoại và địa chỉ trước khi gửi
                fields.phone = btoa(fields.phone); // Mã hóa số điện thoại
                fields.address = btoa(fields.address); // Mã hóa địa chỉ

                for (const key in fields) {
                    if (fields.hasOwnProperty(key)) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = fields[key];
                        form.appendChild(input);
                    }
                }

                document.body.appendChild(form);
                form.submit();
            });
        },
        onError: function(err) {
            console.error(err);
            alert('Có lỗi xảy ra với PayPal. Vui lòng thử lại.');
        }
    }).render('#paypal-button-container');
</script>
