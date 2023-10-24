// Code to display selected pizzas when the page loads
document.addEventListener("DOMContentLoaded", function () {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const selectedPizzasList = document.getElementById("selectedPizzasList2");
  const totalPriceElement = document.getElementById("totalPrice");

  const submitButton = document.getElementById("submitButton");
  submitButton.addEventListener("click", function () {
    const cartInput = document.createElement("input");
    cartInput.type = "hidden";
    cartInput.name = "cartData";
    cartInput.value = JSON.stringify(cart);
    document.getElementById("pizzaForm").appendChild(cartInput);
    document.getElementById("pizzaForm").submit();
    localStorage.removeItem("cart");
  });

  // Function to update and display selected pizzas
  function updateSelectedPizzas() {
    selectedPizzasList.innerHTML = "";
    let totalPrice = 0;

    cart.forEach(function (pizza, index) {
      const listItem = document.createElement("li");

      // Create a container for pizza information (including text and image)
      const pizzaInfo = document.createElement("div");
      pizzaInfo.classList.add("pizza-info");

      // Display pizza information
      const pizzaText = document.createElement("p");
      pizzaText.textContent = `Name: ${pizza.name}, Price: €${pizza.price}, Amount: ${pizza.quantity}`;
      pizzaInfo.appendChild(pizzaText);

      // Create an image element for the pizza
      const imageUrl = `${URLROOT}${pizza.path}`;
      const pizzaImage = document.createElement("img");
      pizzaImage.src = imageUrl;
      pizzaImage.alt = "Pizza Image";
      pizzaImage.style.maxWidth = "100px";
      pizzaInfo.appendChild(pizzaImage);

      // Add a "Delete" button
      const deleteButton = document.createElement("button");
      deleteButton.textContent = "Delete";
      deleteButton.addEventListener("click", function () {
        if (pizza.quantity > 1) {
          // If quantity is greater than 1, decrease the quantity
          pizza.quantity--;
        } else {
          // If quantity is 1, remove the pizza from the cart
          cart.splice(index, 1);
        }
        updateSelectedPizzas();
        saveCartToLocalStorage(); // Don't forget to save the updated cart to local storage
      });

      // Add the pizza information and delete button to the list item
      listItem.appendChild(pizzaInfo);
      listItem.appendChild(deleteButton);

      // Add the list item to the selected pizzas list
      selectedPizzasList.appendChild(listItem);

      totalPrice += parseFloat(pizza.price) * pizza.quantity;
    });

    totalPriceElement.textContent = totalPrice.toFixed(2);
  }

  // Function to save the cart to local storage
  function saveCartToLocalStorage() {
    localStorage.setItem("cart", JSON.stringify(cart));
  }

  // Initially call the updateSelectedPizzas to display the saved data
  updateSelectedPizzas();
});
