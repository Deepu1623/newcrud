$(document).on("click", ".toggle-status-btn", function () {
	let button = $(this);
	let studentId = button.data("id");

	Swal.fire({
		title: "Are you sure?",
		text: "Do you want to change this student's status?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, change it!",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: base_url + "index.php/User/toggle_status",
				method: "POST",
				data: { admission_id: studentId },
				success: function (response) {
					// Parse JSON if response is string
					let res =
						typeof response === "string" ? JSON.parse(response) : response;

					if (res.success) {
						Swal.fire(
							"Updated!",
							"Student status has been changed.",
							"success",
						).then(() => {
							// Reload the page after user closes alert
							location.reload();
						});
					} else {
						Swal.fire("Failed!", "Could not update status.", "error");
					}
				},
				error: function () {
					Swal.fire("Error!", "Server error occurred.", "error");
				},
			});
		}
	});
});

$(document).ready(function () {
	$("#student_admission").on("submit", function (event) {
		event.preventDefault();

		const form = this;

		// Check if all required fields are valid (ignores optional ones like photo)
		if (!form.checkValidity()) {
			form.classList.add("was-validated");
			return;
		}

		const formData = new FormData(form);

		Swal.fire({
			title: "Are you sure?",
			text: "Do you want to submit this data?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, Submit it!",
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url + "index.php/User/new_student_admission",
					type: "POST",
					data: formData,
					processData: false,
					contentType: false,
					success: function (response) {
						if (response.trim() == "success") {
							Swal.fire({
								title: "Success!",
								text: "Stuent admission successfully completed.",
								icon: "success",
								confirmButtonText: "OK",
							}).then(() => {
								window.location.href =
									base_url + "index.php/User/student_admission";
							});
						} else if (response.trim() == "exists") {
							Swal.fire({
								title: "Error!",
								text: "Stuent  already exists",
								icon: "error",
								confirmButtonText: "OK",
							});
						} else {
							Swal.fire({
								title: "Error!",
								text: "failed. Please try again.",
								icon: "error",
								confirmButtonText: "OK",
							});
						}
					},
					error: function (xhr) {
						Swal.fire({
							title: "Error!",
							text: "Registration failed: " + xhr.responseText,
							icon: "error",
							confirmButtonText: "OK",
						});
					},
				});
			}
		});
	});

	//edit student form

	$("#student_update_form").on("submit", function (event) {
		event.preventDefault();

		const form = this;
		if (!form.checkValidity()) {
			form.classList.add("was-validated");
			return;
		}

		const formData = new FormData(form);

		Swal.fire({
			title: "Are you sure?",
			text: "Do you want to update this data?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, Update it!",
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url + "index.php/User/update_student_ajax",
					type: "POST",
					data: formData,
					processData: false,
					contentType: false,
					success: function (response) {
						if (response.trim() === "success") {
							Swal.fire("Updated!", "Student details updated.", "success").then(
								() => {
									window.location.href =
										base_url + "index.php/User/student_report";
								},
							);
						} else if (response.trim() == "exists") {
							Swal.fire({
								title: "Error!",
								text: "Stuent name and number already exists",
								icon: "error",
								confirmButtonText: "OK",
							});
						} else {
							Swal.fire("Error!", "Update failed. Please try again.", "error");
						}
					},
					error: function (xhr) {
						Swal.fire("Error!", "Error: " + xhr.responseText, "error");
					},
				});
			}
		});
	});

	//data table active studnt list

	if ($.fn.DataTable.isDataTable("#studentTable")) {
		$("#studentTable").DataTable().destroy(); // agar pehle init hai to destroy kar de
	}

	var table = $("#studentTable").DataTable({
		responsive: true,
		processing: true,
		serverSide: false,
		ajax: {
			url: base_url + "index.php/User/get_students_ajax",
			type: "POST",
			data: function (d) {
				d.name = $("#filter-name").val();
				d.admission_id = $("#filter-admission-id").val();
			},
		},
		columns: [
			{
				data: "srno",
			},
			{
				data: "admission_id",
			},
			{
				data: "name",
			},
			{
				data: "number",
			},
			{
				data: "plan",
			},
			{
				data: "fees",
			},
			{
				data: "created_at",
			},
			{
				data: "action",
				orderable: false,
				searchable: false,
			},
		],
	});

	// Make sure this event is inside the same block where 'table' is defined
	$("#filter-name, #filter-admission-id").on("change", function () {
		table.ajax.reload();
	});

	$("#registrationForm").on("submit", function (event) {
		event.preventDefault(); // Prevent the default form submission

		const name = $("#name").val();
		const phone = $("#phone").val();
		const email = $("#email").val();
		const userID = $("#userID").val();
		const password = $("#password").val();

		Swal.fire({
			title: "Are you sure?",
			text: "Do you want to regiterd?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, Update it!",
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url + "User/register",
					type: "POST",
					data: {
						name: name,
						phone: phone,
						userID: userID,
						password: password,
						email: email,
					},
					success: function (response) {
						if (response.trim() == "success") {
							Swal.fire({
								title: "Success!",
								text: "User registration successfully completed.",
								icon: "success",
								confirmButtonText: "OK",
							}).then(() => {
								// Redirect to the login page after the user clicks 'OK'
								window.location.href = base_url + "index.php/User/loginpage";
							});
						} else if (response.trim() == "exists") {
							Swal.fire({
								title: "Error!",
								text: "User ID already exists. Please try a new ID.",
								icon: "error",
								confirmButtonText: "OK",
							});
						} else {
							Swal.fire({
								title: "Error!",
								text: "Registration failed. Please try again.",
								icon: "error",
								confirmButtonText: "OK",
							});
						}
					},
					error: function (xhr) {
						Swal.fire({
							title: "Error!",
							text: "Registration failed: " + xhr.responseText,
							icon: "error",
							confirmButtonText: "OK",
						});
					},
				});
			}
		});
	});

	//doucument ends here
});

function getting_fees() {
	const plan = $("#plan").val();

	$.ajax({
		url: base_url + "index.php/User/getting_fees_by_month",
		type: "POST",
		data: {
			plan: plan,
		},
		success: function (response) {
			$("#fees").val(response); // Set the fee value into input
		},
		error: function () {
			alert("Failed to fetch fee.");
		},
	});
}
