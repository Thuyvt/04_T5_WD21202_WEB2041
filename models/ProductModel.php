<?php

class ProductModel extends BaseModel {
    // TOP 4 sản phẩm mới nhất
    public function getTop4Lastest() {
        $sql = "SELECT pro.*, pro_im.image_url 
        FROM `products` as pro LEFT JOIN product_images as pro_im
        ON pro.id = pro_im.product_id 
        AND pro_im.is_main = 1 ORDER BY pro.id DESC LIMIT 4;"; 
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Danh sách sản phẩm
    public function getAll() {
        $sql = "SELECT pro.*, cat.name as category_name 
        FROM `products` as pro 
        JOIN categories as cat 
        ON pro.category_id = cat.id
        ORDER BY pro.id DESC; ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get By ID
    public function getByID($id) {
        $sql = "SELECT pro.*, cat.name as category_name 
        FROM `products` as pro 
        JOIN categories as cat 
        ON pro.category_id = cat.id 
        AND pro.id = :id ;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Delete by Id
    public function delete($id) {
        // Vẫn muốn xóa trong TH có bản ghi trong bảng con liên quan
        // C1: Sửa lại mối quan hệ CASCASE, SET NULL
        // C2: Xóa bản ghi liên quan nếu CSDL vẫn dùng RETRIC
        // Xóa bảng con
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

}