import { loader, inputErrorFeedback, alert } from "./components/General.js";

//Event that handles the submit of the administrator login form
$("#adiministratorLogin").on("submit", async function (e) {
	try {
		e.preventDefault();

		//declaring and asigning variables needed for the for execution.
		let form = $(this);
		let submit = $(this).find("button:submit");
		let submitText = submit.text();
		let data = new FormData(this);

		//unsetting all feedbacks
		form.find(".feedback").remove();
		form.find(".alert").remove();

		//disabling the submit button and changing the inner html
		submit.prop({ disabled: true }).html(loader);

		data.append("adminlogin", true);

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
		submit.prop({ disabled: false }).text(submitText);

		// variable for the message retrieve from the ajax call
		let message = register.message;

		//Conditional statement for when the ajax call is sucessfull or not
		if (register.status == "success") {
			alert(message, "success").insertAfter(form.find(".form-title"));
			setTimeout(() => (location.href = "/admin"), 500);
		} else {
			if (typeof message == "object") {
				$.each(message, (i, el) => {
					form.find(`#${i}`)
						.parents(".field")
						.append(inputErrorFeedback(el, "danger"));
				});
			} else {
				alert(message, "danger").insertAfter(form.find(".form-title"));
			}
		}
	} catch (error) {
		// console.error(error.responseText, error);
	}
});

//Event that handles the submit of the administrator registration form
$("#administratorRegister").on("submit", async function (e) {
	try {
		e.preventDefault();

		//declaring and asigning variables needed for the execution.
		let submit = $(this).find("button:submit");
		let form = $(this);
		let submitText = submit.text();
		let data = new FormData(this);

		//unsetting all feedbacks
		form.find(".feedback").remove();

		//disabling the submit button and changing the inner html
		submit.prop({ disabled: true }).html(loader);

		data.append("adminregister", true);

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
		submit.prop({ disabled: false }).text(submitText);

		// variable for the message retrieve from the ajax call
		let message = register.message;

		//Conditional statement for when the ajax call is sucessfull or not
		if (register.status == "success") {
			alert(message, "success").insertAfter(
				$("#adiministratorLogin").find(".form-title")
			);
			form.find("input").val("");
			form.parents(".modal").modal("hide");
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
		// console.error(error.responseText, error);
	}
});
