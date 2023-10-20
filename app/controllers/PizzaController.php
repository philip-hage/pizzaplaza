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

    public function pizzaOverview($pageNumber = NULL)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            $pizza = $this->pizzaModel->getPizzaByIngredient($post['selected_ingredients']);
            $ingredienten = $this->pizzaModel->getIngredienten();
    
            $data = [
                'title' => "Pizza shop",
                'pizza' => $pizza,
                'ingrediënten' => $ingredienten
            ];
            $this->view('pizza/pizzaOverview', $data);
        } else {
            $totalRecords = count($this->pizzaModel->getAllPizzas());
            $pagination = $this->pagination($pageNumber, 3, $totalRecords);
            $pizza = $this->pizzaModel->getAllPizzasByPagination($pagination['offset'], $pagination['recordsPerPage']);

            $ingredienten = $this->pizzaModel->getIngredienten();
    
            $data = [
                'title' => "Pizza shop",
                'pizza' => $pizza,
                'ingrediënten' => $ingredienten,
                'pageNumber' => $pagination['pageNumber'],
                'nextPage' => $pagination['nextPage'],
                'previousPage' => $pagination['previousPage'],
                'totalPages' => $pagination['totalPages'],
                'firstPage' => $pagination['firstPage'],
                'secondPage' => $pagination['secondPage'],
                'thirdPage' => $pagination['thirdPage'],
                'offset' => $pagination['offset'],
                'recordsPerPage' => $pagination['recordsPerPage'],
            ];
            $this->view('pizza/pizzaOverview', $data);
        }
    }

    public function pizzaCheckout()
    {
        $data = [
            'title' => 'Pizza Checkout'
        ];
    }
}
