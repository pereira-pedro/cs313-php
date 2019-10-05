var PRODUCT_TEMPLATE = "";

/**
 * This is a shortcut to jQuery ready function. It's called right after DOM is loaded and ready.
 */
$(function() {
  $.get("../product-card-template.html", function(data) {
    PRODUCT_TEMPLATE = data;

    // fetch products and creates products card
    fetchProducts();
  });
});

/**
 * Fetch products and create cards
 */
function fetchProducts() {
  // use jQuery to fetch JSON file with products
  $.getJSON("../backend/product-list.php", function(response) {
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

/**
 * Creates an DOM object based on object and partial HTML data
 * @param {Object} container
 * @param {Object} assignment
 */
function createProductCard(container, product) {
  var htmlItem = PRODUCT_TEMPLATE.replace(/ID/g, product.id)
    .replace(/TITLE/g, product.title)
    .replace(/PICTURE/g, product.picture)
    .replace(/PRICE/g, product.price)
    .replace(/RATING/g, renderRating(product.rating));

  var newProductCard = $(htmlItem);

  container.append(newProductCard);

  newProductCard.find(".btn-primary").click(function() {
    var myCard = $(this).closest(".card");

    $.post(
      "../backend/product-add.php",
      {
        id: myCard.data("id"),
        qty: 1
      },
      function(response) {
        if (response.status === "OK") {
          myCard.addClass("shaking");
          setTimeout(function() {
            myCard.removeClass("shaking");
          }, 800);
          $("#cart-items").val(response.data);
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

/**
 * Render a rating to the product
 * @param {Int} rating
 */
function renderRating(rating) {
  var html = "";

  for (i = 0; i < 5; i++) {
    html += `<span class="fa fa-star ${i < rating ? "checked" : ""}"></span>`;
  }

  return html;
}
