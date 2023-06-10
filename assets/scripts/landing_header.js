import { loader, inputErrorFeedback, alert } from "./components/General.js";
$("#voterLogin").on("submit", async function (e) {
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

		data.append("voterlogin", true);

		// ajax call for the form submission
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

		// // variable for the message retrieve from the ajax call
		let message = register.message;

		// //Conditional statement for when the ajax call is sucessfull or not
		if (register.status == "success") {
			form.prepend(alert(message, "success"));
			setTimeout(() => (location.href = "/voters"), 500);
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
});
