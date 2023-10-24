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
        $params = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $urlQuery = '';
        if (isset($params['selected_ingredients'])) {
            $totalRecords = count($this->pizzaModel->getPizzaByIngredient($params['selected_ingredients']));
            $pagination = $this->pagination($pageNumber, 3, $totalRecords);
            $pizza = $this->pizzaModel->getPizzaByIngredientByPagination($params['selected_ingredients'], $pagination['offset'], $pagination['recordsPerPage']);
            $queryString = http_build_query(['selected_ingredients' => $params['selected_ingredients']], '', '&', PHP_QUERY_RFC3986);
            $urlQuery = '?' . $queryString;
        } else {
            $totalRecords = count($this->pizzaModel->getAllPizzas());
            $pagination = $this->pagination($pageNumber, 3, $totalRecords);
            $pizza = $this->pizzaModel->getAllPizzasByPagination($pagination['offset'], $pagination['recordsPerPage']);
        }

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
            'urlQuery' => $urlQuery,
        ];
        $this->view('pizza/pizzaOverview', $data);
    }

    // public function pizzaOverview($pageNumber = NULL)
    // {
    //     var_dump($pageNumber);
    //     $post = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //     var_dump($post);exit;
    //     if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    //         $post = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //         var_dump($post);exit;
    //         // ?page=1
    //         $pizza = $this->pizzaModel->getPizzaByIngredient($post['selected_ingredients']);
    //         $ingredienten = $this->pizzaModel->getIngredienten();

    //         $data = [
    //             'title' => "Pizza shop",
    //             'pizza' => $pizza,
    //             'ingrediënten' => $ingredienten
    //         ];
    //         $this->view('pizza/pizzaOverview', $data);
    //     } else {
    //         $totalRecords = count($this->pizzaModel->getAllPizzas());
    //         $pagination = $this->pagination($pageNumber, 3, $totalRecords);
    //         $pizza = $this->pizzaModel->getAllPizzasByPagination($pagination['offset'], $pagination['recordsPerPage']);

    //         $ingredienten = $this->pizzaModel->getIngredienten();

    //         $data = [
    //             'title' => "Pizza shop",
    //             'pizza' => $pizza,
    //             'ingrediënten' => $ingredienten,
    //             'pageNumber' => $pagination['pageNumber'],
    //             'nextPage' => $pagination['nextPage'],
    //             'previousPage' => $pagination['previousPage'],
    //             'totalPages' => $pagination['totalPages'],
    //             'firstPage' => $pagination['firstPage'],
    //             'secondPage' => $pagination['secondPage'],
    //             'thirdPage' => $pagination['thirdPage'],
    //             'offset' => $pagination['offset'],
    //             'recordsPerPage' => $pagination['recordsPerPage'],
    //         ];
    //         $this->view('pizza/pizzaOverview', $data);
    //     }
    // }

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

            if (empty($cart)) {
                header('Location: ' . URLROOT . 'pizzacontroller/pizzaOverview/1/');
            } else {
                foreach ($cart as $pizza) {
                    $this->pizzaModel->addPizzaToOrder($orderId, $pizza['id'], $pizza['quantity']);
                }

                header('Location: ' . URLROOT . 'pizzacontroller/pizzaOrder/' . $orderId);
            }
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
