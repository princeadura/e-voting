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
let organizationVoter = async function () {
	let data = {
		organization: $("main").data("organization"),
		getVoter: true,
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
async function editVoter(field) {
	let email = $(field).data("email");
	let clickedUser = [...(await organizationVoter())].filter(
		(el) => el.email == email
	)[0];
	let inputFields = [...$("#editUserForm input")];
	inputFields.forEach((input) => {
		let id = $(input).attr("id");
		$(input).val(clickedUser[id]);
	});
	$("#editUserForm").data({ id: clickedUser.voter_id });
	$("#editUser").modal("show");
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
async function deleteVoter(field) {
	let email = $(field).data("email");
	let clickedUser = [...(await organizationVoter())].filter(
		(el) => el.email == email
	)[0];
	let area = $("#deleteUser .user");
	let button = $("#deleteUser .modal-body button");
	button.data({
		voter_id: clickedUser.voter_id,
	});
	area.text(`${clickedUser.firstname} ${clickedUser.lastname}`);
	$("#deleteUser").modal("show");
}
async function editElection(field) {
	let id = $(field).data("id");
	let clickedElection = [...(await organizationElection())].filter(
		(el) => el.election_id == id
	)[0];
	let inputFields = [...$("#editElectionForm input")];
	inputFields.forEach((input) => {
		let id = $(input).attr("id");
		switch (id) {
			case "election_start_date":
			case "election_end_date":
				$(input).val(clickedElection[id].split(" ")[0]);
				break;
			default:
				$(input).val(clickedElection[id]);
				break;
		}
	});
	if (clickedElection.election_status.toLowerCase() !== "pending") {
		$("#editElectionForm")
			.find("#election_start_date")
			.prop({ readonly: true });
		$("#editElectionForm").find("#election_name").prop({ readonly: true });
	} else {
		$("#editElectionForm")
			.find("#election_start_date")
			.prop({ readonly: false });
		$("#editElectionForm").find("#election_name").prop({ readonly: false });
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

function openEditModal(me) {
	let id = $(me).data("id");
	let name = $(me).data("name");
	$("#editPositionForm").data({ index_id: id });
	$("#editPositionModal").find("#position").val(name);
	$("#editPositionModal").modal("show");
}
function openDeleteModal(me) {
	let id = $(me).data("id");
	let name = $(me).data("name");
	$("#deletePositionModal").find(".delete").data({ index_id: id });
	$("#deletePositionModal").find(".position").text(name);
	$("#deletePositionModal").modal("show");
}
