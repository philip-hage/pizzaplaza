document.addEventListener("DOMContentLoaded", function () {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

  
    // Add event listeners to the "Add To Cart" buttons
    const addToCartButtons = document.querySelectorAll(".addToCartBtn");
    addToCartButtons.forEach(function (button) {
      button.addEventListener("click", function () {
        const card = button.parentElement;
        const pizzaId = card.querySelector('.pizzaId').value;
        const pizzaName = card.querySelector('.pizzaName').value;
        const pizzaPrice = card.querySelector('.pizzaPrice').value;
        const pizzaPath = card.querySelector('.pizzaPath').value;

        alert(`"${pizzaName}" has been added to your basket.`);
        
        addToCart(pizzaId, pizzaName, pizzaPrice, pizzaPath);
        updateSelectedPizzas();
      });
    });
  
    function addToCart(pizzaId, pizzaName, pizzaPrice, pizzaPath) {
      cart.push({ id: pizzaId, name: pizzaName, price: pizzaPrice, path: pizzaPath });
      saveCartToLocalStorage();
    }
  
    function saveCartToLocalStorage() {
      localStorage.setItem("cart", JSON.stringify(cart));
    }
  
    // Function to update and display selected pizzas
    function updateSelectedPizzas() {
        const selectedPizzasContainer = document.getElementById("selectedPizzasContainer");
        const selectedPizzasList = document.getElementById("selectedPizzasList");
        const totalPriceElement = document.getElementById("totalPrice");
        let totalPrice = 0; // Initialize the total price to 0

        // Clear the existing list and reset the total price
        selectedPizzasList.innerHTML = "";

        if (cart.length > 0) {
            selectedPizzasContainer.style.display = "block";

            // Loop through the items in the cart and display them
            cart.forEach(function (pizza, index) {
                const listItem = document.createElement("li");
                listItem.textContent = `Name: ${pizza.name}, Price: €${pizza.price}`;

                // Create an img element for the pizza image
                const imageUrl = `${URLROOT}${pizza.path}`;
                const pizzaImage = document.createElement("img");
                pizzaImage.src = imageUrl;
                pizzaImage.alt = "Pizza Image";
                pizzaImage.style.maxWidth = "100px"; // Set the maximum width for the image

                // Create a "Delete" button
                const deleteButton = document.createElement("button");
                deleteButton.textContent = "Delete";
                deleteButton.addEventListener("click", function () {
                    // Remove the pizza from the cart and update the display
                    cart.splice(index, 1);
                    saveCartToLocalStorage();
                    updateSelectedPizzas();
                });

                // Append the image, "Delete" button, and list item to the selectedPizzasList
                listItem.appendChild(pizzaImage);
                listItem.appendChild(deleteButton);
                selectedPizzasList.appendChild(listItem);

                // Update the total price
                totalPrice += parseFloat(pizza.price);
            });

            // Display the total price at the bottom
            totalPriceElement.textContent = `Total Price: €${totalPrice.toFixed(2)}`;
        } else {
            selectedPizzasContainer.style.display = "none";
        }
    }
  
    // Load the cart count and data when the page loads
    updateSelectedPizzas();
  });
