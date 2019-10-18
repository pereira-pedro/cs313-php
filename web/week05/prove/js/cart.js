/**
 * A currency formatter
 */
var formatter = new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "USD"
});
/**
 * This is a shortcut to jQuery ready function. It's called right after DOM is loaded and ready.
 */
$(function() {
  // fetch products and creates products card
  showCart();

  // shows a form checkout as a modal
  $(".proceed-checkout").click(function() {
    $("#form-cart-checkout").modal("show");
  });
});

/**
 * Show cart
 */
function showCart() {
  // use jQuery to fetch JSON file with cart
  $.getJSON("backend/cart-list.php", function(response) {
    var cartList = $("#cart-list");

    // an error found
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
      $("#cart-items-total").html(formatter.format(response.data.total));
    } else {
      cartList.append($(`<h2 class="text-muted">Your cart is empty.</h2>`));
      $("#cart-items-num").html("");
      $("#cart-items-total").html("");
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
 * Creates an DOM object based on object
 * @param {Object} container
 * @param {Object} cart
 */
function showCartDetails(container, cartItem) {
  var newCartItem = $("<tr/>");

  newCartItem.append(
    `<td class="p-2">${cartItem.title}</td>
     <td class="p-2 text-center"><input type="text" class="form-control form-control-sm" value="${
       cartItem.qty
     }" data-id="${cartItem.id}"></td>
     <td class="p-2 text-right">${formatter.format(cartItem.price)}</td>
     <td class="p-2 text-right">${formatter.format(
       cartItem.qty * cartItem.price
     )}<i data-id="${cartItem.id}"class="fa fa-trash remove-item ml-1"></i></td>
    `
  );

  // appends new object to DOM
  container.append(newCartItem);

  // change quantity
  newCartItem.find("input").change(function() {
    updateCart($(this).data("id"), $(this).val(), true);
  });

  // remove item from cart
  newCartItem.find(".remove-item").click(function() {
    updateCart($(this).data("id"), 0, false);
  });
}

/**
 * This function updates cart in session
 * @param {Number} id
 * @param {Number} qty
 * @param {Boolean} update
 */
function updateCart(id, qty, update) {
  // call backup to update session
  $.post(
    "backend/product-add.php",
    {
      id: id,
      qty: qty,
      update: update
    },
    function(response) {
      // show new cart if it's ok
      if (response.status === "OK") {
        showCart();
      } else {
        swal({
          type: "error",
          title: "Error",
          text: `${error.status} ${error.statusText}`
        });
      }
    }
  );
}
