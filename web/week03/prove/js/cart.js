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
  // use jQuery to fetch JSON file with products
  $.getJSON("backend/cart-list.php", function(response) {
    var productList = $("#product-list");

    if (response.status !== "OK") {
      swal({
        type: "error",
        title: "Error",
        text: response.message
      });
      return;
    }

    // remove previous products
    productList.children().remove();

    // iterates through products array
    if (response.data.length > 0) {
      $.each(response.data, function(key, row) {
        createProductCard(productList, row);
      });
    }
  }).fail(function(error) {
    swal({
      type: "error",
      title: "Error",
      text: `${error.status} ${error.statusText}`
    });
  });
}
