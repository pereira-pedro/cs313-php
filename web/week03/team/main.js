/**
 * This is a shortcut to jQuery ready function. It's called right after DOM is loaded and ready.
 */
$(function() {
  // this event handles the div 3 visibility using jQuery
  $("#form1").submit(function(event) {
    $("#results-container").hide();

    submitForm($("#results-container"));
    event.preventDefault();
  });
});

/**
 * This method submits form
 */
function submitForm(container) {
  $.post("../backend/form-handler.php", $("#form1").serialize(), function(
    response
  ) {
    Object.keys(response).forEach(function(key) {
      var newElement = $("<div />", {
        class: "d-flex justify-content-between"
      })
        .append(`<div class="p-2">${key}</div>`)
        .append(`<div class="p-2">${Reflect.get(response, key)}</div>`);

      var newButton = $("<button/>", {
        class: "btn",
        text: "Show Form"
      });

      container.append(newElement);
      container.append(newButton);

      $("#form-container").slideUp("slow", function() {
        container.show("slow");
      });
    });
  });
}
