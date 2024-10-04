Chào bạn!

Dưới đây là phiên bản **README.md** đã được chỉnh sửa và bổ sung thêm hướng dẫn cài đặt **PHPMailer**, **Vulca(s)**, và **Autoload** cho dự án **E.Miu_Shop** của bạn.

---

# E.Miu_Shop

## Mô Tả Dự Án

**E.Miu_Shop** là một nền tảng thương mại điện tử được phát triển bằng PHP, nhằm cung cấp trải nghiệm mua sắm trực tuyến tiện lợi và hiệu quả cho người dùng. Dự án này bao gồm các tính năng chính như quản lý sản phẩm, giỏ hàng, thanh toán trực tuyến, và quản lý người dùng, giúp doanh nghiệp dễ dàng quản lý và mở rộng hoạt động kinh doanh trực tuyến.

### Các Tính Năng Chính

- **Quản Lý Sản Phẩm**: Thêm, sửa, xóa sản phẩm với các thông tin chi tiết.
- **Giỏ Hàng**: Cho phép người dùng thêm sản phẩm vào giỏ hàng, cập nhật số lượng và xóa sản phẩm.
- **Thanh Toán**: Hỗ trợ các phương thức thanh toán trực tuyến an toàn và bảo mật, sử dụng PayPal và Momo.
- **Quản Lý Người Dùng**: Đăng ký, đăng nhập, quản lý thông tin tài khoản và lịch sử đơn hàng.
- **Quản Trị Viên**: Dashboard quản lý tổng quan, quản lý đơn hàng, người dùng và báo cáo kinh doanh.

## Hướng Dẫn Cài Đặt

### Yêu Cầu Hệ Thống

- **Web Server**: Apache hoặc Nginx
- **PHP**: Phiên bản 7.4 trở lên
- **Database**: MySQL
- **Composer**: Công cụ quản lý các gói PHP

### Các Bước Cài Đặt

1. **Clone Repository**

    Trên máy tính của bạn, mở Terminal hoặc Command Prompt và chạy lệnh sau để clone repository:

    ```bash
    git clone https://github.com/TênNgườiDùng/E.Miu_Shop.git
    ```

2. **Điều Hướng Vào Thư Mục Dự Án**

    ```bash
    cd E.Miu_Shop
    ```

3. **Cài Đặt Các Gói Phụ Thuộc**

    Sử dụng Composer để cài đặt các thư viện cần thiết:

    ```bash
    composer install
    ```

4. **Cài Đặt PHPMailer**

    **PHPMailer** được sử dụng để gửi email trong dự án. Để cài đặt PHPMailer, chạy lệnh sau:

    ```bash
    composer require phpmailer/phpmailer
    ```

5. **Cài Đặt Vulca(s)**

    *Lưu ý: Nếu "Vulca(s)" là một thư viện cụ thể mà bạn đang sử dụng, hãy thay thế `vendor/vulcas` bằng tên chính xác của gói.*

    ```bash
    composer require vendor/vulcas
    ```

    **Ví dụ:** Nếu Vulca(s) là một gói có tên là `vulca/superpackage`, bạn sẽ chạy:

    ```bash
    composer require vulca/superpackage
    ```

6. **Cấu Hình Autoload**

    Composer cung cấp tự động tải các lớp (autoload) cho dự án của bạn. Đảm bảo rằng bạn đã bao gồm tệp autoload trong các tệp PHP chính của dự án.

    **Thêm dòng sau vào đầu các tệp PHP cần sử dụng autoload:**

    ```php
    require 'vendor/autoload.php';
    ```

7. **Cấu Hình Môi Trường**

    - Tạo file `.env` từ file mẫu `.env.example`:

      ```bash
      cp .env.example .env
      ```

    - Mở file `.env` và chỉnh sửa các thông số kết nối database:

      ```
      DB_HOST=localhost
      DB_PORT=3306
      DB_DATABASE=ten_database
      DB_USERNAME=ten_user
      DB_PASSWORD=mat_khau
      ```

8. **Tạo Cơ Sở Dữ Liệu**

    - Tạo một cơ sở dữ liệu mới trong MySQL và nhập các bảng cần thiết từ file `database.sql` (nếu có).

9. **Chạy Các Lệnh Diễn Migrations và Seeders**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

10. **Khởi Chạy Server**

    ```bash
    php artisan serve
    ```

    Mở trình duyệt và truy cập `http://localhost:8000` để xem ứng dụng.

## Cách Sử Dụng

### Đăng Ký và Đăng Nhập

1. **Đăng Ký Tài Khoản Mới**
   - Truy cập trang đăng ký.
   - Nhập thông tin cần thiết như tên, email, mật khẩu và xác nhận mật khẩu.
   - Nhấn nút "Đăng ký" để tạo tài khoản.

2. **Đăng Nhập**
   - Truy cập trang đăng nhập.
   - Nhập email và mật khẩu đã đăng ký.
   - Nhấn nút "Đăng nhập" để truy cập vào tài khoản.

### Mua Sắm Sản Phẩm

1. **Duyệt Sản Phẩm**
   - Trên trang chủ, duyệt qua các danh mục sản phẩm.
   - Nhấp vào sản phẩm để xem chi tiết.

2. **Thêm Sản Phẩm Vào Giỏ Hàng**
   - Trong trang chi tiết sản phẩm, chọn số lượng và nhấn "Thêm vào giỏ hàng".

3. **Quản Lý Giỏ Hàng**
   - Truy cập giỏ hàng để xem các sản phẩm đã chọn.
   - Cập nhật số lượng hoặc xóa sản phẩm nếu cần.

4. **Thanh Toán**
   - Khi đã hoàn tất việc chọn sản phẩm, nhấn nút "Thanh toán".
   - Chọn phương thức thanh toán và hoàn tất giao dịch.

### Quản Lý Đơn Hàng

1. **Xem Lịch Sử Đơn Hàng**
   - Truy cập trang "Đơn hàng của tôi" để xem các đơn hàng đã đặt.

2. **Theo Dõi Trạng Thái Đơn Hàng**
   - Kiểm tra trạng thái giao hàng và tiến độ xử lý đơn hàng.

## Liên Hệ

Nếu bạn có bất kỳ câu hỏi hoặc đóng góp nào cho dự án, hãy liên hệ với tôi

Chúc bạn thành công với dự án **E.Miu_Shop**!
