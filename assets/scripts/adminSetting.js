import { loader, inputErrorFeedback, alert } from "./components/General.js";

$(".setting-toggle").each((i, toggle) => {
	$(toggle).on("click", () => {
		$(".settings-form").each((index, setting) =>
			$(setting).toggleClass("active", index === i)
		);
		$(".setting-toggle").each((index, toggle) =>
			$(toggle).toggleClass("active", index === i)
		);
	});
});

$("#personal").on("submit", async function (e) {
	e.preventDefault();
	performAjax(this, "updateAdminDetail");
});

$("#organization").on("submit", async function (e) {
	e.preventDefault();
	performAjax(this, "addOrganization");
});
$("#passwordReset").on("submit", async function (e) {
	e.preventDefault();
	performAjax(this, "resetAdminPassword");
});

async function performAjax(field, postName) {
	try {
		//declaring and asigning variables needed for the for execution.
		let submit = $(field).find("button:submit");
		let form = $(field);
		let submitText = submit.text();
		let data = new FormData(field);

		//unsetting all feedbacks
		form.parent().find(".feedback").remove();

		//disabling the submit button and changing the inner html
		submit.prop({ disabled: true }).html(loader);

		data.append(postName, true);

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
			form.parent().prepend(alert(message, "success"));
		} else {
			if (typeof message == "object") {
				$.each(message, (i, el) => {
					form.find(`#${i}`)
						.parents(".field")
						.append(inputErrorFeedback(el, "danger"));
				});
			} else {
				form.parent().prepend(alert(message, "danger"));
			}
		}
	} catch (error) {
		console.error(error.responseText, error);
	}
}
