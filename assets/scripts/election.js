import { loader, inputErrorFeedback, alert } from "./components/General.js";

$(".delete").on("click", async function () {
	let election_id = $(this).parents("#deleteElection").data("id");
	let parent = $(this).parent();
	let data = { election_id, deleteElection: true };
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
