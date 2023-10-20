<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Plaza</title>
    <link rel="stylesheet" href="<?= URLROOT; ?>public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pizza Plaza</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <h3 class="text-center"><?= $data['title'] ?></h3>
    <div class="container" style="display: flex; height: 100%;">
        <div style="background-color: azure;" class="col-2">
            <h4>Ingredients Filter</h4>
            <form action="<?=URLROOT?>pizzacontroller/pizzaOverview" method="post">
                <ul>
                    <?php foreach ($data['ingrediënten'] as $ingrediënt) : ?>
                        <li>
                            <label>
                                <input type="checkbox" name="selected_ingredients[]" value="<?php echo $ingrediënt->ingredientName; ?>">
                                <?php echo $ingrediënt->ingredientName; ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <button class="btn btn-success " type="submit">Filter</button>
                <a href="<?=URLROOT?>pizzacontroller/pizzaOverview/1" class="btn btn-success ">Reset Filter</a>
            </form>
        </div>

        <div style="flex-grow: 1;" class="col-8">
            <div class="row">
                <?php foreach ($data['pizza'] as $pizza) : ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?= URLROOT . $pizza->pizzaPath ?>" class="card-img-top" alt="Image 1">
                            <div class="card-body">
                                <p class="card-text"><?= $pizza->pizzaName ?></p>
                                <strong><em>€<?= $pizza->pizzaPrice ?></em></strong>
                                <br> <br>
                                <button class="btn btn-primary addToCartBtn">Add To Cart</button>
                                <input type="hidden" class="pizzaId" value="<?= $pizza->pizzaId ?>">
                                <input type="hidden" class="pizzaName" value="<?= $pizza->pizzaName ?>">
                                <input type="hidden" class="pizzaPrice" value="<?= $pizza->pizzaPrice ?>">
                                <input type="hidden" class="pizzaPath" value="<?= $pizza->pizzaPath ?>">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
        <div class="col-2" id="selectedPizzasContainer" style="display: none; background-color: #37752e;">
            <h4>Selected Pizzas</h4>
            <ul id="selectedPizzasList"></ul>
            <p id="totalPrice"></p> <!-- Add this element for the total price -->
            <button class="btn btn-success">Checkout</button>
        </div>
    </div>

    <?php if (!empty($data['pageNumber'])): ?>
    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <!-- Dit lijstitem wordt gebruikt voor de "Vorige" paginaknop. De 'disabled' class wordt toegevoegd als de waarde van $data['previousPage']
         kleiner is dan of gelijk is aan 0, wat aangeeft dat er geen vorige pagina is om naar terug te keren.
         De knop leidt naar de vorige pagina in de reeks. -->
        <li class="page-item <?= ($data['previousPage'] <= 0) ? 'disabled' : ''; ?>">
            <a class="page-link" href="<?=URLROOT?>pizzacontroller/pizzaOverview/<?= $data['previousPage'] ?>">Previous</a>
        </li>
        <!-- Dit is een lijstitem voor de eerste paginaknop. Als de huidige pagina de eerste pagina is, wordt 'active' toegevoegd
         aan de class van het element, anders wordt het vorige paginanummer of de volgende pagina minus 2 weergegeven. -->
        <li class="page-item <?= ($data['pageNumber'] == 1) ? 'active' : ''; ?>"><a class="page-link" href="<?= $data['firstPage'] ?>">
                <?= $data['firstPage'] ?>
            </a></li>
        <?php if ($data['totalPages'] >= 2): ?>
            <li class="page-item <?= ($data['pageNumber'] != 1 && $data['totalPages'] != $data['pageNumber'] || ($data['totalPages'] == 2 && $data['pageNumber'] == 2)) ? 'active' : ''; ?>"><a class="page-link" href="<?= $data['secondPage'] ?>">
                    <?= $data['secondPage'] ?>
                </a></li>
        <?php endif; ?>

        <?php if ($data['totalPages'] >= 3): ?>
            <li class="page-item <?= ($data['pageNumber'] == $data['totalPages']) ? 'active' : ''; ?>"><a class="page-link" href="<?= $data['thirdPage'] ?>">
                    <?= $data['thirdPage'] ?>
                </a></li>
        <?php endif; ?>
        <li class="page-item <?= ($data['nextPage'] > $data['totalPages']) ? 'disabled' : ''; ?>">
            <a class="page-link" href="<?=URLROOT?>pizzacontroller/pizzaOverview/<?= $data['nextPage'] ?>">Next</a>
        </li>
    </ul>
    </nav>
<?php endif; ?>


    <style>
        html,
        body {
            height: 100%;
        }
    </style>

    <script src="<?= URLROOT; ?>public/js/app.js"></script>

</body>

</html>