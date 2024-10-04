<?php 
session_start();
include('../config/dbcon.php');
include('../functions/myfunctions.php');

// Upload image helper
function upload_image($image, $path, $old_image = null) {
    $image_ext = pathinfo($image['name'], PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    move_uploaded_file($image['tmp_name'], "$path/$filename");

    // Remove old image if it exists
    if ($old_image && file_exists("$path/$old_image")) {
        unlink("$path/$old_image");
    }

    return $filename;
}

// Add Category
if (isset($_POST["add_category_btn"])) {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';
    $image = $_FILES['image'];
    $path = "../uploads";

    $filename = upload_image($image, $path);

    $cate_query = "INSERT INTO categories (name, slug, description, meta_title, meta_description, meta_keywords, status, popular, image)
                    VALUES ('$name', '$slug', '$description', '$meta_title', '$meta_description', '$meta_keywords', '$status', '$popular', '$filename')";

    if (mysqli_query($con, $cate_query)) {
        redirect('add-category.php', 'Category Added Successfully');
    } else {
        redirect("add-category.php", "Something Went Wrong");
    }
}

// Update Category
else if (isset($_POST["update_category_btn"])) {
    $category_id = $_POST["category_id"];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';
    $new_image = $_FILES['image']['name'] ? upload_image($_FILES['image'], "../uploads", $_POST['old_image']) : $_POST['old_image'];

    $update_query = "UPDATE categories SET name='$name', slug='$slug', description='$description', meta_title='$meta_title',
                     meta_description='$meta_description', meta_keywords='$meta_keywords', status='$status', popular='$popular', image='$new_image'
                     WHERE id='$category_id'";

    if (mysqli_query($con, $update_query)) {
        redirect("edit-category.php?id=$category_id", "Category Updated Successfully");
    } else {
        redirect("edit-category.php?id=$category_id", "Something went wrong");
    }
}

// Delete Category
else if (isset($_POST["delete_category_btn"])) {
    $category_id = mysqli_real_escape_string($con, $_POST["category_id"]);
    $category_query = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM categories WHERE id='$category_id'"));

    if (mysqli_query($con, "DELETE FROM categories WHERE id='$category_id'")) {
        if (file_exists("../uploads/" . $category_query["image"])) {
            unlink("../uploads/" . $category_query["image"]);
        }
        echo 200;
    } else {
        echo 500;
    }
}

// Add Product
else if (isset($_POST["add_product_btn"])) {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $qty = $_POST['qty'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';
    $filename = upload_image($_FILES['image'], "../uploads");

    $product_query = "INSERT INTO products (category_id, name, slug, small_description, description, original_price, selling_price, qty, meta_title, meta_description, meta_keywords, status, trending, image)
                      VALUES ('$category_id', '$name', '$slug', '$small_description', '$description', '$original_price', '$selling_price', '$qty', '$meta_title', '$meta_description', '$meta_keywords', '$status', '$trending', '$filename')";

    if (mysqli_query($con, $product_query)) {
        redirect("add-product.php", "Product Added Successfully");
    } else {
        redirect("add-product.php", "All fields are mandatory");
    }
}

// Update Product
else if (isset($_POST["update_product_btn"])) {
    $product_id = $_POST['product_id'];
    $category_id = $_POST['category_id'];  
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $qty = $_POST['qty'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';
    $new_image = $_FILES['image']['name'] ? upload_image($_FILES['image'], "../uploads", $_POST['old_image']) : $_POST['old_image'];

    $update_product_query = "UPDATE products SET category_id='$category_id', name='$name', slug='$slug', small_description='$small_description', description='$description', original_price='$original_price', selling_price='$selling_price', qty='$qty',
                             meta_title='$meta_title', meta_description='$meta_description', meta_keywords='$meta_keywords', status='$status', trending='$trending', image='$new_image' WHERE id='$product_id'";

    if (mysqli_query($con, $update_product_query)) {
        redirect("edit-product.php?id=$product_id", "Product Updated Successfully");
    } else {
        redirect("edit-product.php?id=$product_id", "Something went wrong");
    }
}

// Delete Product
else if (isset($_POST["delete_product_btn"])) {
    $product_id = mysqli_real_escape_string($con, $_POST["product_id"]);
    $product_query = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM products WHERE id='$product_id'"));

    if (mysqli_query($con, "DELETE FROM products WHERE id='$product_id'")) {
        if (file_exists("../uploads/" . $product_query["image"])) {
            unlink("../uploads/" . $product_query["image"]);
        }
        echo 200;
    } else {
        echo 500;
    }
}

// Update Order Status
else if (isset($_POST["update_order_btn"])) {
    $tracking_no = $_POST['tracking_no'];
    $order_status = $_POST['order_status'];

    $updateOrder_query = "UPDATE orders SET status='$order_status' WHERE tracking_no='$tracking_no'";
    if (mysqli_query($con, $updateOrder_query)) {
        redirect("view-order.php?t=$tracking_no", "Order Status updated successfully");
    } else {
        redirect("view-order.php?t=$tracking_no", "Something went wrong");
    }
}

// Update User
else if (isset($_POST['update_user_btn'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $role_as = mysqli_real_escape_string($con, $_POST['role_as']);

    if (strlen($phone) != 10) {
        $_SESSION['message'] = "Số điện thoại phải có 10 chữ số";
        header("Location: edit_user.php?id=$user_id");
        exit();
    }

    $email_check_query = "SELECT * FROM users WHERE email='$email' AND id != '$user_id'";
    if (mysqli_num_rows(mysqli_query($con, $email_check_query)) > 0) {
        $_SESSION['message'] = "Email đã tồn tại";
        header("Location: edit_user.php?id=$user_id");
        exit();
    }

    $phone_check_query = "SELECT * FROM users WHERE phone='$phone' AND id != '$user_id'";
    if (mysqli_num_rows(mysqli_query($con, $phone_check_query)) > 0) {
        $_SESSION['message'] = "Số điện thoại đã tồn tại";
        header("Location: edit_user.php?id=$user_id");
        exit();
    }

    $update_query = "UPDATE users SET name='$name', email='$email', phone='$phone', role_as='$role_as' WHERE id='$user_id'";

    if (mysqli_query($con, $update_query)) {
        redirect("edit_user.php?id=$user_id", "Cập nhật thành công");
    } else {
        redirect("edit_user.php?id=$user_id", "Có lỗi xảy ra");
    }
}

?>
