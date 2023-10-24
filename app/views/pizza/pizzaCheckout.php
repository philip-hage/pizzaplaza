<?php require APPROOT . '/views/includes/head.php'; ?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= URLROOT ?>pizzacontroller/pizzaOverview/1/">Pizza Plaza</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
<h3 class="text-center"><?= $data['title'] ?></h3>


<div class="container" style="display: flex; height: 100%;">
    <div class="col-6" style="margin-right: 50px;">
        <div class="customerForm">
            <div id="formContainer">
                <strong>
                    <p>
                        Where should we deliver your pizza?
                    </p>
                </strong>
                <form action="<?= URLROOT; ?>pizzacontroller/pizzaCheckout" method="post" class="form-group" id="pizzaForm">
                    <label for="streetName">StreetName</label>
                    <input type="text" id="streetName" name="streetname" class="form-control" placeholder="StreetName" required>
                    <label for="houseNumber">HouseNumber</label>
                    <input type="text" id="houseNumber" name="housenumber" class="form-control" placeholder="HouseNumber" required>
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control" placeholder="Zipcode" required>
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" class="form-control" placeholder="City" required>
                    <br>
                    <strong>
                        <p>
                            How can we contact you?
                        </p>
                    </strong>
                    <label for="customerName">Name</label>
                    <input type="text" id="customerName" name="customername" class="form-control" placeholder="Name" required>

                    <label for="email">Email</label>
                    <input type="text" id="email" name="customeremail" class="form-control" placeholder="Email" required>

                    <label for="phoneNumber">Phone Number</label>
                    <input type="text" id="phoneNumber" name="phonenumber" class="form-control" placeholder="PhoneNumber" required>
                </form>
                <div id="messageContainer" class="hidden"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="selected-pizzas">
            <h3 class="text-center">Selected Pizzas</h3>
            <ul id="selectedPizzasList2">
                <!-- The selected pizzas will be displayed here -->
            </ul>
            <p class="text-center">Total Price: €<span id="totalPrice">0</span></p>
            <button id="submitButton" class="btn btn-primary btn-lg" style="width: 100%;">Submit Order</button>
        </div>
    </div>
</div>
<script src="<?= URLROOT; ?>public/js/pizzaCheckout.js"></script>
<?php require APPROOT . '/views/includes/footer.php'; ?>
