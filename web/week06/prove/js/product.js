const formatter = new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "USD"
});

const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000
});

/**
 * This is a shortcut to jQuery ready function. It's called right after DOM is loaded and ready.
 */
$(function() {
  $("#frm-product").submit(function(event) {
    event.preventDefault();
    const description = {
      title: $("#det-title").val(),
      subtitle: $("#det-subtitle").val(),
      details: []
    };

    $("#product-features li").each(function() {
      description.details.push($(this).text());
    });

    $("#description").val(JSON.stringify(description));

    $("#action").val("save");

    $.post("backend/product-controller.php", $(this).serialize(), function(
      response
    ) {
      if (response.status === "OK") {
        Toast.fire({
          type: "success",
          title: response.message
        });
        $("#id").val(response.id);
      } else {
        Swal.fire({
          type: "error",
          title: "Error",
          text: response.message
        });
      }
    });
  });

  $("#btn-det-feature").click(function() {
    $("#product-features").append(
      $("<li>", { class: "list-group-item" }).text($("#det-feature").val())
    );
  });

  $("#btn-delete").click(function() {
    $("#action").val("delete");
    $.post(
      "backend/product-controller.php",
      $("#frm-product").serialize(),
      function(response) {
        if (response.status === "OK") {
          Toast.fire({
            type: "success",
            title: response.message
          });
          $("#frm-product").trigger("reset");

          emptyForm();
        } else {
          Swal.fire({
            type: "error",
            title: "Error",
            text: response.message
          });
        }
      }
    );
  });

  $("#frm-product").on("reset", function(e) {
    emptyForm();
  });

  $("#title").typeahead({
    source: function(query, process) {
      return $.get("backend/product-autocomplete.php", { key: query }, function(
        data
      ) {
        return process(data);
      });
    },
    afterSelect: function(item) {
      retrieveProduct(item.id);
    }
  });
});

function retrieveProduct(id) {
  $("#id").val(id);
  $("#action").val("retrieve");
  $.post(
    "backend/product-controller.php",
    $("#frm-product").serialize(),
    function(response) {
      if (response.status === "OK") {
        $("#product-features").empty();

        $.each(response.data, function(key, row) {
          $(`#${key}`).val(row);
        });

        const productFeatures = $.parseJSON(response.data.description);
        $("#det-title").val(productFeatures.title);
        $("#det-subtitle").val(productFeatures.subtitle);

        const listContainer = $("#product-features");
        $.each(productFeatures.details, function(key, row) {
          listContainer.append($(`<li class="list-group-item">${row}</li>`));
        });
      } else {
        Swal.fire({
          type: "error",
          title: "Error",
          text: response.message
        });
      }
    }
  );
}

function emptyForm() {
  $("#product-features").empty();
  $("#id").val("");
  $("#description").val("");
  $("#action").val("");
}
