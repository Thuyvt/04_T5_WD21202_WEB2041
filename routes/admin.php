<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new ProductController)->index(),

    'product-list' => (new ProductController)->index(), // Hiển thị trang danh sách sp
    'product-show' => (new ProductController)->show(), // Hiển thị trang chi tiết sp
    'product-create' => (new ProductController)->create(), // Hiển thị trang tạo mới
    'product-edit' => (new ProductController)->edit(), // Hiển thị trang cập nhật
    'product-delete' => (new ProductController)->delete(), // Thực hiện xóa sản phẩm
    'product-store' => (new ProductController)->store(), // Lưu dữ liệu vào CSDL
    'product-update' => (new ProductController)->update(), // Cập nhật dữ liệu vào CSDL

};