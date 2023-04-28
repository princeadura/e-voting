import { loader, inputErrorFeedback, alert } from "./components/General.js";

//events for when the head admin wants to add some regular admin
$("#addAdminForm").on("submit", function (e) {
	e.preventDefault();
	performAjax(this, "addAdmin");
});

//events for when the head admin wants to edit the info of regular admin
$("#editAdminForm").on("submit", function (e) {
	e.preventDefault();
	let id = $(this).data("id");
	performAjax(this, "editAdmin", { admin_id: id });
});

//events for when the  admin wants to add election
$("#addElectionForm").on("submit", function (e) {
	e.preventDefault();
	performAjax(this, "addElection");
});

//events for when the  admin wants to add election
$("#editElectionForm").on("submit", function (e) {
	e.preventDefault();
	let id = $(this).data("id");
	performAjax(this, "editElection", { election_id: id });
});

//The main function that powers the ajax call made in this file
async function performAjax(field, formname, id = null) {
	try {
		//declaring and asigning variables needed for the for execution.
		let submit = $(field).find("button:submit");
		let form = $(field);
		let submitText = submit.html();
		let data = new FormData(field);

		if (id) {
			for (const key in id) {
				data.append(key, id[key]);
			}
		}

		//unsetting all feedbacks
		form.find(".feedback").remove();

		//disabling the submit button and changing the inner html
		submit.prop({ disabled: true }).html(loader);

		data.append(formname, true);

		//ajax call for the form submission
		const register = await $.ajax({
			method: "POST",
			url: "/src/request.php",
			data: data,
			dataType: "json",
			contentType: false,
			processData: false,
			cache: false,
		});

		// enabling the submit button and changing the value back to the default value
		submit.prop({ disabled: false }).html(submitText);

		// variable for the message retrieve from the ajax call
		let message = register.message;

		//Conditional statement for when the ajax call is sucessfull or not
		if (register.status == "success") {
			form.prepend(alert(message, "success"));
			form.find("input").val("");
			location.reload();
		} else {
			if (typeof message == "object") {
				$.each(message, (i, el) => {
					form.find(`#${i}`)
						.parents(".field")
						.append(inputErrorFeedback(el, "danger"));
				});
			} else {
				form.prepend(alert(message, "danger"));
			}
		}
	} catch (error) {
		console.error(error.responseText, error);
	}
}
