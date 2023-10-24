document.addEventListener("DOMContentLoaded", function () {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const selectedPizzasContainer = document.getElementById(
    "selectedPizzasContainer"
  );

  // Add event listeners to the "Add To Cart" buttons
  const addToCartButtons = document.querySelectorAll(".addToCartBtn");
  addToCartButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      const card = button.parentElement;
      console.log(card);
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
      cart.forEach(function (pizza, index) {
        // Create a new list item for each pizza
        const listItem = document.createElement("li");
        listItem.classList.add("dr-cart__product");

        // Create an <img> element for pizza image
        const imageUrl = `${URLROOT}${pizza.path}`;
        const pizzaImage = document.createElement("img");
        pizzaImage.classList.add("dr-cart__img");
        pizzaImage.src = imageUrl;

        // Create an <h2> element for pizza name
        const pizzaName = document.createElement("h2");
        pizzaName.classList.add("text-sm");
        pizzaName.textContent = pizza.name;

        // Create an <h2> element for pizza name
        const pizzaAmount = document.createElement("h2");
        pizzaAmount.classList.add("text-sm");
        pizzaAmount.textContent = pizza.quantity + "x";

        const textDiv = document.createElement("div");
        textDiv.appendChild(pizzaName);
        textDiv.appendChild(pizzaAmount);

        // Create a <p> element for pizza price
        const pizzaPrice = document.createElement("p");
        pizzaPrice.classList.add("text-sm", "color-contrast-higher");
        pizzaPrice.textContent = `$${pizza.price}`;

        // Create a button for removing the pizza
        const removeButton = document.createElement("button");
        removeButton.classList.add("dr-cart__remove-btn", "margin-top-xxxs");
        removeButton.textContent = "Remove";

        removeButton.addEventListener("click", function () {
          if (pizza.quantity > 1) {
            // If the quantity is greater than 1, decrement the quantity
            pizza.quantity--;
          } else {
            // If the quantity is 1, remove the entire entry from the cart
            cart.splice(index, 1);
          }
          // Update the local storage after removing an item
          saveCartToLocalStorage();
          // Update the selected pizzas display
          updateSelectedPizzas();
        });

        const textRightDiv = document.createElement("div");
        textRightDiv.classList.add("text-right");
        textRightDiv.appendChild(pizzaPrice);
        textRightDiv.appendChild(removeButton);

        listItem.appendChild(pizzaImage);
        listItem.appendChild(textDiv);
        listItem.appendChild(textRightDiv);

        selectedPizzasList.appendChild(listItem);

        totalPrice += parseFloat(pizza.price) * pizza.quantity;
      });

      totalPriceElement.textContent = `Total Price: €${totalPrice.toFixed(2)}`;
    }
  }

  updateSelectedPizzas();
});
