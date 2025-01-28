<?php
class Product
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getNewArrivals()
    {
        $sql = "SELECT * FROM products WHERE is_new_arrival = 1";
        $result = $this->db->query($sql);
        return $result;
    }

    public function getOnSaleProducts()
    {
        $sql = "SELECT * FROM products WHERE is_on_sale = 1";
        $result = $this->db->query($sql);
        return $result;
    }

    public function getCategories()
    {
        $sql = "SELECT DISTINCT category FROM products";
        $result = $this->db->query($sql);
        return $result;
    }

    public function getProductsByCategory($category)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE category = ?");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function formatPrice($price, $onSale = false)
    {
        if ($onSale) {
            return number_format($price * 0.8, 2);
        }
        return number_format($price, 2);
    }
}
