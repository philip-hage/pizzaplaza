<?php

class PizzaModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllPizzas()
    {
        $this->db->query("SELECT pizzaId,
                                 pizzaName,
                                 pizzaPrice,
                                 pizzaPath
                                 FROM pizza
                                 WHERE pizzaIsActive = 1");
        return $this->db->resultSet();
    }

    public function getAllPizzasByPagination($offset, $limit)
    {
        $this->db->query("SELECT pizzaId,
                                 pizzaName,
                                 pizzaPrice,
                                 pizzaPath
                                 FROM pizza
                                 WHERE pizzaIsActive = 1
                                 LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getPizzaById($pizzaId)
    {
        $this->db->query("SELECT pizzaId,
                                 pizzaName,
                                 pizzaPrice
                                 FROM pizza
                                 WHERE pizzaId = :pizzaId");
        $this->db->bind(':pizzaId', $pizzaId);
        return $this->db->single();
    }

    public function getIngredienten()
    {
        $this->db->query("SELECT ingredientId,
                                 ingredientName
                                 FROM ingredients
                                 WHERE ingredientIsActive = 1");
        return $this->db->resultSet();
    }

    public function getPizzaByIngredient($ingredients)
    {
        $placeholders = implode(', ', array_fill(0, count($ingredients), '?'));
        $this->db->query("SELECT p.pizzaId, p.pizzaName, p.pizzaPrice, p.pizzaPath, i.ingredientId, i.ingredientName, pi.pizzaId, pi.ingredientId
                            FROM pizzahasingredients as pi
                            INNER JOIN pizza as p ON pi.pizzaId = p.pizzaId
                            INNER JOIN ingredients as i ON pi.ingredientId = i.ingredientId
                            WHERE i.ingredientName IN ($placeholders)
                            AND p.pizzaIsActive = 1
                            GROUP BY p.pizzaId");

        // Bind the ingredient names to the placeholders
        foreach ($ingredients as $key => $ingredientName) {
            $this->db->bind($key + 1, $ingredientName);
        }

        return $this->db->resultSet();
    }

    public function getPizzaByIngredientByPagination($ingredients, $offset, $limit)
    {
        $placeholders = implode(', ', array_fill(0, count($ingredients), '?'));
        $this->db->query("SELECT p.pizzaId, p.pizzaName, p.pizzaPrice, p.pizzaPath, i.ingredientId, i.ingredientName, pi.pizzaId, pi.ingredientId
                            FROM pizzahasingredients as pi
                            INNER JOIN pizza as p ON pi.pizzaId = p.pizzaId
                            INNER JOIN ingredients as i ON pi.ingredientId = i.ingredientId
                            WHERE i.ingredientName IN ($placeholders)
                            AND p.pizzaIsActive = 1
                            GROUP BY p.pizzaId
                            LIMIT :offset, :limit");

        // Bind the ingredient names to the placeholders
        foreach ($ingredients as $key => $ingredientName) {
            $this->db->bind($key + 1, $ingredientName);
        }
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }

    public function createCustomer($post)
    {
        global $var;
        $customerId = $var['rand'];
        $this->db->query("INSERT INTO customer (customerId, customerName, customerStreetName, customerHouseNumber, customerZipcode, customerCity, customerEmail, customerPhone, customerCreateDate)
                          VALUES (:id, :customername, :customerstreetname, :customerhousenumber, :customerzipcode, :customercity, :customeremail, :customerphone, :customercreatedate)");
        $this->db->bind(':id', $customerId);
        $this->db->bind(':customername', $post['customername']);
        $this->db->bind(':customerstreetname', $post['streetname']);
        $this->db->bind(':customerhousenumber', $post['housenumber']);
        $this->db->bind(':customerzipcode', $post['zipcode']);
        $this->db->bind(':customercity', $post['city']);
        $this->db->bind(':customeremail', $post['customeremail']);
        $this->db->bind(':customerphone', $post['phonenumber']);
        $this->db->bind(':customercreatedate', $var['timestamp']);
        $this->db->execute();
        return $customerId;
    }

    public function getCustomerById($customerId)
    {
        $this->db->query("SELECT customerId,
                                 customerName,
                                 customerStreetName,
                                 customerHouseNumber,
                                 customerZipcode,
                                 customerCity,
                                 customerEmail,
                                 customerPhone
                                 FROM customer
                                 WHERE customerId = :customerId");
        $this->db->bind(':customerId', $customerId);
        return $this->db->single();
    }

    public function getOrder($orderId)
    {
        try {
            $this->db->query("SELECT
                c.customerId,
                c.customerName,
                c.customerStreetName,
                c.customerHouseNumber,
                c.customerZipcode,
                c.customerCity,
                c.customerEmail,
                c.customerPhone,
                o.orderCreateDate
                FROM `order` as o
                INNER JOIN customer as c ON o.customerId = c.customerId
                WHERE o.orderId = :orderId");
            $this->db->bind(':orderId', $orderId);
            return $this->db->single();
        } catch (PDOException $e) {
            // Handle the exception, e.g., log the error, show an error message, or return a default value.
            echo "Database error: " . $e->getMessage();
        }
    }

    public function addPizzaToOrder($orderId, $pizzaId, $quantity)
    {
        $this->db->query("INSERT INTO `orderhaspizzas` (orderId, pizzaId, pizzaAmount)
                          VALUES (:orderId, :pizzaId, :pizzaAmount)");
        $this->db->bind(':orderId', $orderId);
        $this->db->bind(':pizzaId', $pizzaId);
        $this->db->bind(':pizzaAmount', $quantity);
        return $this->db->execute();
    }

    public function selectCustomerEmail($customerEmail)
    {
        $this->db->query("SELECT customerId
                                 FROM customer 
                                 WHERE customerEmail = :customerEmail");
        $this->db->bind(':customerEmail', $customerEmail);
        return $this->db->single();
    }

    public function createOrder($customerId)
    {
        global $var;
        $orderId = $var['rand'];
        $this->db->query("INSERT INTO `order` (orderId, customerId, orderCreateDate)
                          VALUES (:orderId, :customerId, :ordercreatedate)");
        $this->db->bind(':orderId', $orderId);
        $this->db->bind(':customerId', $customerId);
        $this->db->bind(':ordercreatedate', $var['timestamp']);
        $this->db->execute();
        return $orderId;
    }

    public function getOrderPizzas($orderId)
    {
        try {
            $this->db->query("SELECT
                p.pizzaName,
                p.pizzaPrice,
                ohp.orderId,
                ohp.pizzaId,
                ohp.pizzaAmount
                FROM `orderhaspizzas` as ohp
                INNER JOIN pizza as p ON p.pizzaId = ohp.pizzaId
                WHERE ohp.orderId = :orderId");
            $this->db->bind(':orderId', $orderId);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            // Handle the exception, e.g., log the error, show an error message, or return a default value.
            echo "Database error: " . $e->getMessage();
        }
    }
}
