// used to store template in memory
var ASSIGNMENT_TEMPLATE = "";

/**
 * jQuery ready shortcut
 */
$(function() {
    // get html partial
  $.get("view/assignment-partial.html", function(data) {
    ASSIGNMENT_TEMPLATE = data;

    // fetch assignments and creates assignments card
    fetchAssignments();
  });
});

/**
 * Fetch assignments and create cards
 */
function fetchAssignments() {
    // use jQuery to fetch JSON file with assignments
  $.getJSON("backend/assignments.php", function(response) {
    var assignmentList = $("#assignment-list");

    if (response.status !== "OK") {
      swal({
        type: "error",
        title: "Error",
        text: response.message
      });
      return;
    }

    // remove previous assignments
    assignmentList.children().remove();

    // iterates through assignments array
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

/**
 * Creates an DOM object based on object and partial HTML data
 * @param {Object} container 
 * @param {Object} assignment 
 */
function createAssignmentObject(container, assignment) {
  var htmlItem = ASSIGNMENT_TEMPLATE
    .replace(/ID/g, assignment.id)
    .replace(/TITLE/g, assignment.title)
    .replace(/DESCRIPTION/g, assignment.description)
    .replace(/URL/g, assignment.url)
    .replace(/DUE/g, assignment.due)
    .replace(/STATUS/g, renderStatus(assignment.status));

  var newAssignment = $(htmlItem);

  container.append(newAssignment);
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
