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
                                 pizzaPrice
                                 FROM pizza
                                 WHERE pizzaIsActive = 1");
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
}
