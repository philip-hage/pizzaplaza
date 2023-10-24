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
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $customer = $this->pizzaModel->selectCustomerEmail($post['customeremail']);

            if (isset($customer->customerId)) {
                $orderId = $this->pizzaModel->createOrder($customer->customerId);
            } else {
                $customerId = $this->pizzaModel->createCustomer($post);
                $orderId = $this->pizzaModel->createOrder($customerId);
            }

            $cart = json_decode($_POST['cartData'], true); // Assuming you pass the cart data as a JSON string

            foreach ($cart as $pizza) {
                $this->pizzaModel->addPizzaToOrder($orderId, $pizza['id'], $pizza['quantity']);
            }

            header('Location: ' . URLROOT . 'pizzacontroller/pizzaOrder/' . $orderId);
        }
        $data = [
            'title' => 'Pizza Checkout'
        ];
        $this->view('pizza/pizzaCheckout', $data);
    }

    public function pizzaOrder($orderId = NULL)
    {
        $order = $this->pizzaModel->getOrder($orderId);
        $pizzas = $this->pizzaModel->getOrderPizzas($orderId);
        $data = [
            'title' => 'Pizza Order',
            'order' => $order,
            'pizzas' => $pizzas
        ];
        $this->view('pizza/pizzaOrder', $data);
    }
}
