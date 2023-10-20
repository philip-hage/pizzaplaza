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
    <h3 class="text-center"><?= $data['title'] ?></h3>

    <div class="adresForm">
        <div class="form-group">
            <label for="streetName">StreetName</label>
            <input type="text" id="streetName" class="form-control" placeholder="StreetName">
            <label for="houseNumber"></label>
            <input type="text" id="houseNumber" class="form-control" placeholder="HouseNumber">
            <label for="zipcode"></label>
            <input type="text" id="zipcode" class="form-control" placeholder="Zipcode">
            <label for="city"></label>
            <input type="text" id="city" class="form-control" placeholder="City">
        </div>
    </div>

    <strong>
        <p>
            How can we contact you?
        </p>
    </strong>

    <div class="contactForm">
        <div class="form-group">
            <label for="customerName"></label>
            <input type="text" id="customerName" class="form-control" placeholder="Name">

            <label for="email"></label>
            <input type="text" id="email" class="form-control" placeholder="Email">

            <label for="phoneNumber"></label>
            <input type="text" id="phoneNumber" class="form-control" placeholder="PhoneNumber">  
  
        </div>
    </div>
</body>

</html>