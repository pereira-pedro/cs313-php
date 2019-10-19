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
                SELECT p.id, p.title, price, discount_rate, rating, pi.url AS picture
                FROM product p
                INNER JOIN product_image pi ON pi.id_product = p.id
                WHERE pi.main = true %s",
                $key !== '' ? 'AND p.title LIKE :title' : ''
            )
        );

        $key = '%' . $key . '%';
        $stmt->bindValue(':title', $key, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $rows;
    }

    function getDetails($id)
    {
        $stmt = $this->conn->prepare(
            "
            SELECT title, price, description
            FROM product p
            WHERE id = :id"
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        return $row;
    }
}