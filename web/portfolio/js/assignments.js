var ASSIGNMENT_TEMPLATE = "";

$(function() {
  $.get("../view/assignment-partial.html", function(data) {
    ASSIGNMENT_TEMPLATE = data;

    fetchAssignments();
  });
});

function fetchAssignments() {
  $.getJSON("../backend/assignments.php", function(response) {
    var assignmentList = $("#assignment-list");
    if (response.status !== "OK") {
      swal({
        type: "error",
        title: "Error",
        text: response.message
      });
      return;
    }

    assignmentList.children().remove();

    if (response.data.length > 0) {
      $.each(response.data, function(key, row) {
        createAssignmentObject(assignmentList, row);
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

function createAssignmentObject(container, assignment) {
  var htmlItem = ASSIGNMENT_TEMPLATE.replace(/ID/g, assignment.id)
    .replace(/TITLE/g, assignment.title)
    .replace(/DESCRIPTION/g, assignment.description)
    .replace(/URL/g, assignment.url)
    .replace(/STATUS/g, renderStatus(assignment.status));

  var newAssignment = $(htmlItem);

  container.append(newAssignment);
}

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
