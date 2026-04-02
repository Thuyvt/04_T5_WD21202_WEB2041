<?php

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    // Hiển thị danh sách sản phẩm
    public function index(){
        $view = 'product/index';
        $title = 'Quản lý sản phẩm';
        $data = $this->productModel->getAll();
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    // Hiển thị trang tạo mới sản phẩm
    public function create(){}

    // Hiển thị trang chi tiết sản phẩm
    public function show() {
        $view = 'product/show';
        $title = 'Chi tiết sản phẩm';
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("ID không tồn tại");
            }
            $id = $_GET['id'];
            // Kiểm tra id có trong csld hay không 
            $pro = $this->productModel->getByID($id);
            if (empty($pro)) {
                throw new Exception("Không tồn tại bản ghi");
            }
            require_once PATH_VIEW_MAIN_ADMIN;

        } catch (Exception $ex) {
            throw new Exception ("Đọc chi tiết sản phẩm bị lỗi" . $ex->getmessage());
        }
    }

    // Hiển thị trang cập nhật sản phẩm
    public function edit() {}

    // Thực hiện chức năng xóa
    public function delete() {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("ID không tồn tại");
            }
            $id = $_GET['id'];
            // Kiểm tra id có trong csld hay không 
            $pro = $this->productModel->getByID($id);
            if (empty($pro)) {
                throw new Exception("Không tồn tại bản ghi");
            }
            // thực hiện xóa
            $this->productModel->delete($id);

            // XÓa thành công thì quay lại trang danh sách
            header("Location:" . BASE_URL_ADMIN. '&action=product-list');
        } catch (Exception $ex) {
            throw new Exception ("Có lỗi trong quá trình xóa" . $ex->getmessage());
        }
    }
}