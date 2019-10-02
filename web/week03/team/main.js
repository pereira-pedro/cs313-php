/**
 * This is a shortcut to jQuery ready function. It's called right after DOM is loaded and ready.
 */
$(function() {
  loadContinents($("#list-continents"));
  loadMajors($("#list-continents"));
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
  // clear previous content
  container.empty();

  $.post("../backend/form-handler.php", $("#form1").serialize(), function(
    response
  ) {
    Object.keys(response).forEach(function(key) {
      var newElement = $("<div />", {
        class: "d-flex justify-content-between"
      })
        .append(`<div class="p-2 font-weight-bold">${key}:</div>`)
        .append(`<div class="p-2">${Reflect.get(response, key)}</div>`);

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

function renderValue(value) {
  var buffer = "";
  if (isArray(value)) {
    value.forEach(function(key) {
      buffer += `${key}<br/>`;
    });
  } else {
    buffer = value;
  }

  return buffer;
}
function loadMajors(container) {
  container.empty();

  $.getJSON("../backend/list-majors.php", function(data) {
    var i = 0;
    $.each(data, function(key, val) {
      $("<div/>", {
        class: "form-check",
        html: `
        <input class="form-check-input" type="radio" name="major" value="${val.id} id="major${i}"/>
        <label class="form-check-label" for="major${i}">${val.name}</label>`
      }).appendTo(container);

      i++;
    });
  });
}

function loadContinents(container) {
  container.empty();

  $.getJSON("../backend/list-continents.php", function(data) {
    var i = 0;
    $.each(data, function(key, val) {
      $("<div/>", {
        class: "form-check",
        html: `
        <input class="form-check-input" type="checkbox" value="${val.id}" name="continents[]" id="continent${i}"/>
        <label class="form-check-label" for="continent${i}">${val.name}</label>`
      }).appendTo(container);

      i++;
    });
  });
}
