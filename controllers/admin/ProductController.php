<?php

class ProductController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    // Hiển thị danh sách sản phẩm
    public function index(){
        $view = 'product/index';
        $title = 'Quản lý sản phẩm';
        $data = $this->productModel->getAll();
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    // Hiển thị trang tạo mới sản phẩm
    public function create(){
        $view = 'product/create';
        $title = 'Tạo mới sản phẩm';
        $list_cat = $this->categoryModel->getAll();
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    // Hàm lưu dữ liệu vào CSDL
    public function store() {
        try {
            $data = $_POST + $_FILES;
            // debug($data);

            // Xử lý ảnh 
            if ($data['img_cover']['size'] > 0) {
                $data['img_cover'] = upload_file('products', $data['img_cover']);
            } else {
                $data['img_cover'] = null;
            }
            // thêm dữ liệu vào csdl
            $this->productModel->insert($data);

            // lưu thành công quay lại trang danh sách
            header("Location:" . BASE_URL_ADMIN. '&action=product-list');
        }catch(Exception $ex) {
            throw new Exception("Có lỗi xảy ra" . $ex->getmessage());
        }
    }
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
    public function edit() {
        $view = 'product/edit';
        $title = 'Cập nhật sản phẩm';
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("ID không tồn tại");
            }
            $id = $_GET['id'];
            // Kiểm tra id có trong csld hay không 
            $pro = $this->productModel->getByID($id);
            // debug($pro);
            $list_cat = $this->categoryModel->getAll();
            if (empty($pro)) {
                throw new Exception("Không tồn tại bản ghi");
            }
            require_once PATH_VIEW_MAIN_ADMIN;

        } catch (Exception $ex) {
            throw new Exception ("Đọc chi tiết sản phẩm bị lỗi" . $ex->getmessage());
        }
    }

    // Thực hiện cập nhật dữ liệu
    public function update() {
        try {
            $id = $_GET['id'];
            $pro = $this->productModel->getById($id);
            if(empty($pro)) {
                throw new Exception("Id sản phẩm không đúng");
            }
            $data = $_POST + $_FILES;
             // Xử lý ảnh
            if($data['img_cover']['size'] >0) {
                $data['img_cover'] = upload_file('products', $data['img_cover']);
            } else {
                // Nếu không upload ảnh mới lên thì lấy giá trị ảnh cũ
                $data['img_cover'] == null;
            }
            // Cập nhật dữ liệu mới
            $this->productModel->update($data, $id);

            header("Location:" . BASE_URL_ADMIN. '&action=product-list');

        } catch (Exception $ex) {
            throw new Exception("Có lỗi xảy ra trong quá trình cập nhật" . $ex->getmessage());
        }
    }

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