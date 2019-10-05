/**
 * This is a shortcut to jQuery ready function. It's called right after DOM is loaded and ready.
 */
var formatter = new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "USD"
});

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
     }" data-id="${cartItem.id}"></td>
     <td class="p-2 text-right">${formatter.format(cartItem.price)}</td>
     <td class="p-2 text-right">${formatter.format(
       cartItem.qty * cartItem.price
     )}<i data-id="${cartItem.id}"class="fas fa-trash-alt"></i></td>
    `
  );

  container.append(newCartItem);

  newCartItem.find("input").change(function() {
    $.post(
      "backend/product-add.php",
      {
        id: $(this).data("id"),
        qty: $(this).val()
      },
      function(response) {
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
  });

  newCartItem.find(".fa-trash-alt").click(function() {
    $.post(
      "backend/product-add.php",
      {
        id: $(this).data("id"),
        qty: 0
      },
      function(response) {
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
  });
}
