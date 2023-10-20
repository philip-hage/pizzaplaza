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


}
