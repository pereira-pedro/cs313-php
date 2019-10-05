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
      $("#cart-items-num").html(response.data.items);
      $("#cart-items-total").html(response.data.total);
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
  var newCartItem = $("<tr/>");

  newCartItem.append(
    `<td class="p-2">${cartItem.title}</td>
     <td class="p-2 text-center"><input type="text" class="form-control form-control-sm" value="${
       cartItem.qty
     }"></td>
     <td class="p-2 text-right">${cartItem.price}</td>
     <td class="p-2 text-right">${cartItem.qty * cartItem.price}</td>
    `
  );

  container.append(newCartItem);
}
