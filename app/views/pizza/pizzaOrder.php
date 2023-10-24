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
            <a class="navbar-brand" href="<?= URLROOT ?>pizzacontroller/pizzaOverview/1">Pizza Plaza</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <?php
    // Get the timestamp from the order
    $timestamp = $data['order']->orderCreateDate;

    // Format the timestamp to display the date and time
    $formattedDate = date('Y-m-d H:i:s', $timestamp); ?>

    <div class="text-center">
        <strong>
            <p>
                Thank you for ordering at Pizza Plaza. Your order will be delivered as soon as possible.
            </p>

            <p>
                Order by: <?= $data['order']->customerName ?>
            </p>
            <p>
                Date ordered: <?= $formattedDate ?>
            </p>
        </strong>
    </div>

    <table class="table table-primary table-bordered">
        <thead>
            <tr>
                <th>Amount</th>
                <th>Pizza</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalPrice = 0; ?>
            <?php foreach ($data['pizzas'] as $pizza) {
                $pizzaSubtotal = $pizza->pizzaAmount * $pizza->pizzaPrice;
                $totalPrice += $pizza->pizzaAmount * $pizza->pizzaPrice;
                echo "<tr>
                                <td>" . $pizza->pizzaAmount . "</td>
                                <td>" . $pizza->pizzaName . "</td>
                                <td>" . $pizzaSubtotal  . "</td>
                ";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td id="totalPrice"><?=$totalPrice?></td>
            </tr>
        </tfoot>
    </table>

</body>

</html>