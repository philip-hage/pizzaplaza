<?php

class PizzaController extends Controller
{
    private $pizzaModel;

    public function __construct()
    {
        $this->pizzaModel = $this->model('PizzaModel');
    }

    public function index()
    {
        $data = [
            'title' => "Pizza shop"
        ];
        $this->view('pizza/index', $data);
    }

    public function pizzaOverview()
    {
        $pizza = $this->pizzaModel->getAllPizzas();

        $data = [
            'title' => "Pizza shop",
            'pizza' => $pizza
        ];
        $this->view('pizza/pizzaOverview', $data);
    }
}
