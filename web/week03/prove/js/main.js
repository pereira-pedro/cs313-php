var PRODUCT_TEMPLATE = "";
var formatter = new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "USD"
});

/**
 * This is a shortcut to jQuery ready function. It's called right after DOM is loaded and ready.
 */
$(function() {
  $.get("product-card-template.html", function(data) {
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
  $.getJSON("backend/product-list.php", function(response) {
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
    if (response.data.products.length > 0) {
      $.each(response.data.products, function(key, row) {
        createProductCard(productList, row);
      });

      $("#cart-items").html(response.data.items);
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
  var newProductCard = $(
    PRODUCT_TEMPLATE.replace(/ID/g, product.id)
      .replace(/TITLE/g, product.title)
      .replace(/PICTURE/g, product.picture)
      .replace(/PRICE/g, formatter.format(product.price))
      .replace(/RATING/g, renderRating(product.rating))
  );

  container.append(newProductCard);

  newProductCard.find(".btn-primary").click(function() {
    var myCard = $(this).closest(".card");

    addToCart(myCard, myCard.find("input").val());
  });

  newProductCard.find(".card-title a").click(function() {
    var myCard = $(this).closest(".card");

    $.post(
      "backend/product-detail.php",
      {
        id: myCard.data("id")
      },
      function(response) {
        if (response.status === "OK") {
          $("#form-product-description-title").html(response.data.title);
          $("#form-product-description .product-description-title").html(
            response.data.description.title
          );
          $("#form-product-description .product-description-subtitle").html(
            response.data.description.subtitle
          );
          $("#form-product-description .modal-footer .btn-primary")
            .html(
              `Add to cart <i>(${formatter.format(response.data.price)})</i>`
            )
            .click(function() {
              $("#form-product-description").modal("hide");
              addToCart(myCard, 1);
            });

          var listContainer = $("#form-product-description .list-group");
          $.each(response.data.description.details, function(key, row) {
            listContainer.append($(`<li class="list-group-item">${row}</li>`));
          });

          $("#form-product-description").modal("show");
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

function addToCart(myCard, qty) {
  $.post(
    "backend/product-add.php",
    {
      id: myCard.data("id"),
      qty: qty
    },
    function(response) {
      if (response.status === "OK") {
        myCard.addClass("shaking");
        setTimeout(function() {
          myCard.removeClass("shaking");
        }, 800);
        $("#cart-items").html(response.data.items);
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
