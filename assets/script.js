$(document).ready(() => {
  // Load family tree on page load
  loadFamilyTree();

  // Open modal when Add Member button is clicked
  $("#addMemberBtn").on("click", () => {
    loadParents();
    $("#addMemberModal").show();
  });

  // Close modal when X is clicked
  $(".close").on("click", () => {
    closeModal();
  });

  // Close modal when clicking outside of it
  $(window).on("click", (event) => {
    if (event.target.id === "addMemberModal") {
      closeModal();
    }
  });

  // Close modal when Close button is clicked
  $("#closeModalBtn").on("click", () => {
    closeModal();
  });

  // Handle form submission
  $("#addMemberForm").on("submit", (e) => {
    e.preventDefault();
    addMember();
  });

  // Load family tree
  function loadFamilyTree() {
    $("#familyTree").html('<div class="loading">Loading family tree...</div>');

    $.ajax({
      url: "ajax/get_tree.php",
      type: "GET",
      dataType: "json",
      success: (response) => {
        if (response.success) {
          $("#familyTree").html(
            response.tree ||
              '<div class="loading">No family members found.</div>'
          );
        } else {
          $("#familyTree").html(
            '<div class="alert alert-danger">Error loading family tree.</div>'
          );
        }
      },
      error: () => {
        $("#familyTree").html(
          '<div class="alert alert-danger">Error loading family tree.</div>'
        );
      },
    });
  }

  // Load parents for dropdown
  function loadParents() {
    $("#parentSelect").html('<option value="">Loading...</option>');

    $.ajax({
      url: "ajax/get_parents.php",
      type: "GET",
      dataType: "json",
      success: (response) => {
        if (response.success) {
          let options = '<option value="">-- No Parent (Top Level) --</option>';
          response.parents.forEach((parent) => {
            options += `<option value="${parent.id}">${parent.name}</option>`;
          });
          $("#parentSelect").html(options);
        } else {
          $("#parentSelect").html(
            '<option value="">Error loading parents</option>'
          );
        }
      },
      error: () => {
        $("#parentSelect").html(
          '<option value="">Error loading parents</option>'
        );
      },
    });
  }

  // Add new member
  function addMember() {
    const name = $("#memberName").val().trim();
    const parentId = $("#parentSelect").val();

    if (!name) {
      showAlert("Name is required.", "danger");
      return;
    }

    // Disable submit button
    $("#saveBtn").prop("disabled", true).text("Saving...");

    $.ajax({
      url: "ajax/add_member.php",
      type: "POST",
      data: {
        name: name,
        parent_id: parentId,
      },
      dataType: "json",
      success: (response) => {
        if (response.success) {
          showAlert(response.message, "success");
          $("#addMemberForm")[0].reset();
          loadFamilyTree(); // Reload the tree
          setTimeout(closeModal, 1500); // Close modal after 1.5 seconds
        } else {
          showAlert(response.message, "danger");
        }
      },
      error: () => {
        showAlert("Error adding member. Please try again.", "danger");
      },
      complete: () => {
        // Re-enable submit button
        $("#saveBtn").prop("disabled", false).text("Save changes");
      },
    });
  }

  // Show alert message
  function showAlert(message, type) {
    const alertHtml = `<div class="alert alert-${type}">${message}</div>`;
    $("#alertContainer").html(alertHtml);

    // Auto-hide success messages
    if (type === "success") {
      setTimeout(() => {
        $("#alertContainer").html("");
      }, 3000);
    }
  }

  // Close modal
  function closeModal() {
    $("#addMemberModal").hide();
    $("#addMemberForm")[0].reset();
    $("#alertContainer").html("");
  }
});
