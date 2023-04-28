/* 
	This is the data that is used to fetch fetch the administrators that belongs to the head administrators organization.
*/

let organizationAdmin = async function () {
	let data = {
		organization: $("main").data("organization"),
		getAdmin: true,
	};
	let result = await $.post("/src/request.php", data, null, "json");
	return result;
};
let organizationElection = async function () {
	let data = {
		organization: $("main").data("organization"),
		getElection: true,
	};
	let result = await $.post("/src/request.php", data, null, "json");
	return result;
};

async function editAdmin(field) {
	let email = $(field).data("email");
	let clickedUser = [...(await organizationAdmin())].filter(
		(el) => el.email == email
	)[0];
	let inputFields = [...$("#editAdminForm input")];
	inputFields.forEach((input) => {
		let id = $(input).attr("id");
		$(input).val(clickedUser[id]);
	});
	$("#editAdminForm").data({ id: clickedUser.admin_id });
	$("#editAdmin").modal("show");
}

async function disableAdmin(field) {
	let email = $(field).data("email");
	let act = $(field).text().trim();
	let clickedUser = [...(await organizationAdmin())].filter(
		(el) => el.email == email
	)[0];
	let area = $("#disableAdmin .act");
	let button = $("#disableAdmin .modal-body button");
	if (act.toLowerCase() !== "disable") {
		button.addClass("btn-success");
		button.removeClass("btn-danger");
	} else {
		button.removeClass("btn-success");
		button.addClass("btn-danger");
	}
	button.text(act);
	button.data({
		admin_id: clickedUser.admin_id,
		act: act.toLowerCase(),
	});
	area.text(
		`${act.toLowerCase()} ${clickedUser.firstname} ${clickedUser.lastname}`
	);
	$("#disableAdmin").modal("show");
}
async function deleteAdmin(field) {
	let email = $(field).data("email");
	let clickedUser = [...(await organizationAdmin())].filter(
		(el) => el.email == email
	)[0];
	let area = $("#deleteAdmin .user");
	let button = $("#deleteAdmin .modal-body button");
	button.data({
		admin_id: clickedUser.admin_id,
	});
	area.text(`${clickedUser.firstname} ${clickedUser.lastname}`);
	$("#deleteAdmin").modal("show");
}
async function editElection(field) {
	let id = $(field).data("id");
	let clickedElection = [...(await organizationElection())].filter(
		(el) => el.election_id == id
	)[0];
	let inputFields = [...$("#editElectionForm input")];
	inputFields.forEach((input) => {
		let id = $(input).attr("id");
		$(input).val(clickedElection[id]);
	});
	if (clickedElection.election_status.toLowerCase() !== "pending") {
		$("#editElectionForm")
			.find("#election_start_date")
			.prop({ readonly: true });
	} else {
		$("#editElectionForm")
			.find("#election_start_date")
			.prop({ readonly: false });
	}
	$("#editElectionForm").data({ id });
	$("#editElection").modal("show");
}
async function deleteElection(field) {
	let id = $(field).data("id");
	let clickedElection = [...(await organizationElection())].filter(
		(el) => el.election_id == id
	)[0];
	let message = `Are you sure you want to delete <strong>${clickedElection.election_name}</strong> Election`;

	$("#deleteElection").data({ id });
	$("#deleteElection").find(".message").html(message);
	$("#deleteElection").modal("show");
}
