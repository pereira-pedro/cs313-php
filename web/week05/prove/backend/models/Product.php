<?php
include_once "DB.php";

class Product extends DB
{
    private $conn;

    function __construct()
    {
        parent::__construct();
        $this->conn = $this->getConnection();
    }

    function listProducts($key = '')
    {
        $stmt = $this->conn->prepare(
            sprintf(
                "
                SELECT p.id, title, price, discount_rate, picture, rating, pi.url
                FROM product p
                INNER JOIN product_image pi ON pi.id_product = p.id
                WHERE pi.main = true %s",
                $key !== '' ? 'AND title LIKE :title' : ''
            )
        );
        $stmt->bindValue(':title', "%$key%", PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $rows;
    }
}