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

    function create($product)
    {
        $stmt = $this->conn->prepare(
            "
            INSERT INTO product
            (title, price, description, stock, discount_rate, tax_rate, rating)
            VALUES
            (:title, :price, :description, :stock, :discount_rate, :tax_rate, :rating)
            "
        );
        $stmt->bindValue(':title', $product->title);
        $stmt->bindValue(':price', floatval($product->price));
        $stmt->bindValue(':description', $product->description);
        $stmt->bindValue(':stock', $product->stock, PDO::PARAM_INT);
        $stmt->bindValue(':discount_rate', floatval($product->discount_rate));
        $stmt->bindValue(':tax_rate', floatval($product->tax_rate));
        $stmt->bindValue(':rating', $product->rating, PDO::PARAM_INT);
        $stmt->execute();

        return $this->conn->lastInsertId('product_id_seq');
    }

    function retrieve($id)
    {
        $stmt = $this->conn->prepare(
            "
            SELECT title, price, description, stock, discount_rate, tax_rate, rating
            FROM product
            WHERE id = :id"
        );

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        return $row;
    }

    function update($product)
    {
        var_dump($product);

        $stmt = $this->conn->prepare(
            "
            UPDATE product
            SET
                title = :title, 
                price = :price, 
                description = :description, 
                stock = :stock,
                discount_rate = :discount_rate,
                tax_rate = :tax_rate,
                rating = :rating
            WHERE id = :id
            "
        );
        $stmt->bindValue(':title', $product->title);
        $stmt->bindValue(':price', floatval($product->price));
        $stmt->bindValue(':description', $product->description);
        $stmt->bindValue(':stock', $product->stock, PDO::PARAM_INT);
        $stmt->bindValue(':discount_rate', floatval($product->discount_rate));
        $stmt->bindValue(':tax_rate', floatval($product->tax_rate));
        $stmt->bindValue(':rating', $product->rating, PDO::PARAM_INT);
        $stmt->bindValue(':id', $product->id, PDO::PARAM_INT);
        $stmt->execute();
    }

    function delete($id)
    {
        $stmt = $this->conn->prepare(
            "
            DELETE FROM product
            WHERE id = :id
            "
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    function listAll($key = '')
    {
        $stmt = $this->conn->prepare(
            sprintf(
                "
                SELECT p.id, p.title, price, discount_rate, rating, pi.url AS picture
                FROM product p
                LEFT JOIN product_image pi ON pi.id_product = p.id AND pi.main = true
                %s",
                $key !== '' ? 'WHERE p.title ILIKE :title' : ''
            )
        );
        $stmt->bindValue(':title', $key);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $rows;
    }

    function listAllTA($key = '')
    {
        $stmt = $this->conn->prepare(
            sprintf(
                "
                SELECT id, title
                FROM product
                %s",
                $key !== '' ? 'WHERE title ILIKE :title' : ''
            )
        );
        $stmt->bindValue(':title', $key);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $rows;
    }

    function getDefinition()
    {
        return  [
            'id'    => [
                'filter'    => FILTER_VALIDATE_INT,
                'flags'     => FILTER_REQUIRE_SCALAR || FILTER_NULL_ON_FAILURE
            ],
            'title'      => FILTER_SANITIZE_ENCODED,
            'description'      => FILTER_SANITIZE_ENCODED,
            'price' => [
                'filter' => FILTER_VALIDATE_FLOAT,
                'flags' => FILTER_REQUIRE_SCALAR
            ],
            'discount_rate' => [
                'filter' => FILTER_VALIDATE_FLOAT,
                'flags' => FILTER_REQUIRE_SCALAR, 'options'   => ['min_range' => 0, 'max_range' => 1]
            ],
            'tax_rate' => [
                'filter' => FILTER_VALIDATE_FLOAT,
                'flags' => FILTER_REQUIRE_SCALAR, 'options'   => ['min_range' => 0, 'max_range' => 1]
            ],
            'rating'    => [
                'filter'    => FILTER_VALIDATE_INT,
                'flags'     => FILTER_REQUIRE_SCALAR
            ],
            'stock'    => [
                'filter'    => FILTER_VALIDATE_INT,
                'flags'     => FILTER_REQUIRE_SCALAR
            ]
        ];
    }
}