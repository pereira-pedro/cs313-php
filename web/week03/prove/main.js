var PRODUCT_TEMPLATE = '';

/**
 * This is a shortcut to jQuery ready function. It's called right after DOM is loaded and ready.
 */
$(function() {
  $.get("view/product-card-template.html", function(data) {
    PRODUCT_TEMPLATE = data;

    // fetch assignments and creates assignments card
    fetchProducts();
  });
});

/**
 * This method submits form
 */
function submitForm(container) {
  // clear previous content
  container.empty();

  $.post("backend/form-handler.php", $("#form1").serialize(), function(
    response
  ) {
    Object.keys(response).forEach(function(key) {
      var newElement = $("<div />", {
        class: "d-flex justify-content-between"
      })
        .append(`<div class="p-2 font-weight-bold">${key}:</div>`)
        .append(`<div class="p-2">${renderValue(Reflect.get(response, key))}</div>`);

      container.append(newElement);

      $("#form-container").slideUp("slow", function() {
        container.show("slow");
      });
    });
    var newButton = $("<button/>", {
      class: "btn btn-primary",
      text: "Show Form",
      click: function() {
        container.hide("slow", function() {
          $("#form-container").slideDown("slow");
        });
      }
    });
    container.append(newButton);
  });
}
/**
 * Fetch assignments and create cards
 */
function fetchProducts() {
  // use jQuery to fetch JSON file with assignments
$.getJSON("backend/products.json", function(response) {
  var productList = $("#product-list");

  if (response.status !== "OK") {
    swal({
      type: "error",
      title: "Error",
      text: response.message
    });
    return;
  }

  // remove previous assignments
  productList.children().remove();

  // iterates through assignments array
  if (response.data.length > 0) {
    $.each(response.data, function(key, row) {
      createProductCard(productList, row);
    });
  }
}).fail(function(error) {
  swal({
    type: "error",
    title: "Erro",
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
var htmlItem = PRODUCT_TEMPLATE
  .replace(/ID/g, product.id)
  .replace(/TITLE/g, product.title)
  .replace(/PICTURE/g, product.image)
  .replace(/PRICE/g, assignment.url)
  .replace(/RATING/g, assignment.due);

var newProductCard = $(htmlItem);

container.append(newProductCard);
}

/**
* Render a status badge for current assignment status
* @param {String} status 
*/
function renderStatus(status) {
var cssClass = "";
switch (status.toUpperCase()) {
  case "PENDING":
    cssClass = "danger";
    break;
  case "DONE":
    cssClass = "success";
    break;
  case "WORKING":
    cssClass = "warning";
}

return `<span class="badge badge-${cssClass}">${status}</span>`;
}