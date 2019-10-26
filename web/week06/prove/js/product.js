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
      if (response.status !== "OK") {
        Toast.fire({
          type: "success",
          title: response.message
        });
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
});
