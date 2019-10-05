/**
 * This is a shortcut to jQuery ready function. It's called right after DOM is loaded and ready.
 */

$(function() {
  // fetch products and creates products card
  showCart();
});

/**
 * Show cart
 */
function showCart() {
  // use jQuery to fetch JSON file with cart
  $.getJSON("backend/cart-list.php", function(response) {
    var cartList = $("#cart-list");

    if (response.status !== "OK") {
      swal({
        type: "error",
        title: "Error",
        text: response.message
      });
      return;
    }

    // remove previous cart
    cartList.children().remove();

    // iterates through cart array
    if (response.data.items > 0) {
      $.each(response.data.cart.items, function(key, row) {
        showCartDetails(cartList, row);
      });
    } else {
      cartList.append($(`<div class="text-muted">Your cart is empty.</div>`));
    }
  }).fail(function(error) {
    swal({
      type: "error",
      title: "Error",
      text: `${error.status} ${error.statusText}`
    });
  });
}

/**
 * Creates an DOM object based on object and partial HTML data
 * @param {Object} container
 * @param {Object} cart
 */
function showCartDetails(container, cartItem) {
  var newCartItem = $("<li/>", {
    class: "list-group-item"
  });

  newCartItem.append(
    `<div class="d-flex flex-row mb-3">
        <div class="p-2">${cartItem.title}</div>
        <div class="p-2">${cartItem.qty}</div>
        <div class="p-2">${cartItem.price}</div>
        <div class="p-2">${cartItem.qty * cartItem.price}</div>
    </div>`
  );

  container.append(newCartItem);
}
