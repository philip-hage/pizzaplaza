document.addEventListener("DOMContentLoaded", function () {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const selectedPizzasContainer = document.getElementById(
    "selectedPizzasContainer"
  );


  const basketIcon = document.getElementById("basketIcon");
  basketIcon.addEventListener("click", function (event) {
    event.preventDefault();
    // Toggle the display of the selected pizzas container
    selectedPizzasContainer.style.display =
      selectedPizzasContainer.style.display === "none" ? "block" : "none";
  });

  // Add event listeners to the "Add To Cart" buttons
  const addToCartButtons = document.querySelectorAll(".addToCartBtn");
  addToCartButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      const card = button.parentElement;
      const pizzaId = card.querySelector(".pizzaId").value;
      const pizzaName = card.querySelector(".pizzaName").value;
      const pizzaPrice = card.querySelector(".pizzaPrice").value;
      const pizzaPath = card.querySelector(".pizzaPath").value;

      alert(`"${pizzaName}" has been added to your basket.`);

      addToCart(pizzaId, pizzaName, pizzaPrice, pizzaPath);
      updateSelectedPizzas();
    });
  });

  function addToCart(pizzaId, pizzaName, pizzaPrice, pizzaPath) {
    const existingPizza = cart.find((item) => item.id === pizzaId);
    if (existingPizza) {
      // If it's in the cart, increase its quantity
      existingPizza.quantity++;
    } else {
      // If it's not in the cart, add it as a new item
      cart.push({
        id: pizzaId,
        name: pizzaName,
        price: pizzaPrice,
        path: pizzaPath,
        quantity: 1,
      });
    }
    saveCartToLocalStorage();
  }

  function saveCartToLocalStorage() {
    localStorage.setItem("cart", JSON.stringify(cart));
  }

  // Function to update and display selected pizzas
  function updateSelectedPizzas() {
    const selectedPizzasContainer = document.getElementById(
      "selectedPizzasContainer"
    );
    const selectedPizzasList = document.getElementById("selectedPizzasList");
    const totalPriceElement = document.getElementById("totalPrice");
    let totalPrice = 0;

    selectedPizzasList.innerHTML = "";

    if (cart.length > 0) {
      selectedPizzasContainer.style.display = "none";

      cart.forEach(function (pizza, index) {
        const listItem = document.createElement("li");
        listItem.textContent = `Name: ${pizza.name}, Price: €${pizza.price}, Amount: ${pizza.quantity}`;

        const imageUrl = `${URLROOT}${pizza.path}`;
        const pizzaImage = document.createElement("img");
        pizzaImage.src = imageUrl;
        pizzaImage.alt = "Pizza Image";
        pizzaImage.style.maxWidth = "100px";

        const deleteButton = document.createElement("button");
        deleteButton.textContent = "Delete";
        deleteButton.addEventListener("click", function () {
          if (pizza.quantity > 1) {
            // If quantity is greater than 1, decrease the quantity
            pizza.quantity--;
          } else {
            // If quantity is 1, remove the item from the cart
            cart.splice(index, 1);
          }
          saveCartToLocalStorage();
          updateSelectedPizzas();
        });

        listItem.appendChild(pizzaImage);
        listItem.appendChild(deleteButton);
        selectedPizzasList.appendChild(listItem);

        totalPrice += parseFloat(pizza.price) * pizza.quantity;
      });

      totalPriceElement.textContent = `Total Price: €${totalPrice.toFixed(2)}`;
    } else {
      selectedPizzasContainer.style.display = "none";
    }
  }

  updateSelectedPizzas();
});
