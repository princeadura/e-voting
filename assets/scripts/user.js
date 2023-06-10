import { loader, inputErrorFeedback, alert } from "./components/General.js";

$("#multi-add").on("submit", async function (e) {
	try {
		e.preventDefault();
		let button = $(this).find("button:submit");
		let htmlText = button.html();
		button.prop({ disabled: true }).html(loader);

		$(this).find(".feedback").remove();
		let file = $(this).find("#file")[0].files[0];
		if (typeof file == "undefined") {
			$(this)
				.find("#file")
				.parents(".input")
				.append(inputErrorFeedback("Kindly Select a file", "danger"));
			button.prop({ disabled: false }).html(htmlText);
			return;
		}
		let data = new FormData(this);
		data.append("addMultipleUser", true);
		let add = await $.ajax({
			method: "POST",
			url: "/src/request.php",
			data: data,
			dataType: "json",
			contentType: false,
			processData: false,
			cache: false,
		});
		button.prop({ disabled: false }).html(htmlText);
		let message = add.message;
		if (add.status == "success") {
			$(this).prepend(alert(message, "success"));
			location.reload();
		} else {
			if (typeof message == "object") {
				$.each(message, (i, el) => {
					$(this)
						.find(`#${i}`)
						.parents(".input")
						.append(inputErrorFeedback(el, "danger"));
				});
			} else {
			}
		}
	} catch (error) {
		console.error(error, error.responseText);
	}
});

$(".delete").on("click", async function () {
	let { voter_id } = $(this).data();
	let parent = $(this).parent();
	let data = { voter_id, deleteUser: true };
	try {
		let submitText = $(this).html();
		$(this).prop({ disabled: true }).html(loader);
		let act = await $.post("/src/request.php", data, null, "json");
		$(this).prop({ disabled: false }).html(submitText);
		let message = act.message;
		if (act.status == "success") {
			parent.prepend(alert(message, "success"));
			location.reload();
		} else {
			if (typeof message == "object") {
				$.each(message, (i, el) => {
					parent
						.find(`#${i}`)
						.parents(".field")
						.append(inputErrorFeedback(el, "danger"));
				});
			} else {
				parent.prepend(alert(message, "danger"));
			}
		}
	} catch (error) {
		console.error(error);
	}
});
