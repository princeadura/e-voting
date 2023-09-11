import { loader, inputErrorFeedback, alert } from "./components/General.js";
let addCandidate = $("#addCandidateForm").find("button:submit");
let candidateError = $("#addCandidateErrorModal");
let candidateErrorModal = $(
	"#addCandidateErrorModal .modal-body .container-fluid"
);
let totalCandidates = [...$(".individual-candidate")]
	.map((el) => Number($(el).text().trim()))
	.reduce((total, num) => total + num, 0);
const Icon = (type) =>
	type == "success"
		? `<span class="icon text-success">
<i class="fas fa-circle-check" aria-hidden="true"></i>
</span>`
		: ` <span class="icon text-danger">
		<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
		</span>`;

let handleCandidateSearch = function () {
	let value = $(this).val();
	let names = [...$(".candidate_select_wrapper .name span")];
	if (names.length <= 0) return;
	let container = $(".add-candidate-body");
	container.find(".feedback").remove();
	addCandidate.prop({ disabled: false });
	let searchUser = names.filter((name) => {
		let innerText = name.textContent.toLowerCase();
		return innerText.includes(value.toLowerCase());
	});
	names.forEach((name) => {
		let target = $(name).parents(".candidate_select_wrapper");
		target.toggleClass("hide", !searchUser.includes(name));
	});
	if (searchUser.length <= 0) {
		addCandidate.prop({ disabled: true });
		container.append(inputErrorFeedback("No Result Found", "danger"));
	}
};

let handleCandidateSelected = function () {
	let count = $(".selected").text();
	let checked = !$(this).prev().prop("checked");
	let newCount = checked ? ++count : --count;
	$(".selected").text(newCount);
};

let handleAddCandidate = async function (e) {
	e.preventDefault();
	let { electionId: election, position } = $(this).data();
	let data = new FormData(this);
	data.append("election", election);
	data.append("position", position);
	data.append("addCandidate", true);
	let submitButtonContent = addCandidate.html();
	addCandidate.attr("disabled", "disabled").html(loader());
	candidateErrorModal.empty();
	try {
		let add = await $.ajax({
			type: "POST",
			url: "/src/request.php",
			data: data,
			dataType: "Json",
			contentType: false,
			processData: false,
			cache: false,
		});
		if (add.status == "success") {
			candidateErrorModal.append(Icon("success"));
			candidateErrorModal.append(
				inputErrorFeedback(add.message, "success")
			);
			setTimeout(() => {
				let search = window.location.search
					.split("&")
					.splice(0, 2)
					.join("&");
				let path = window.location.pathname + search;
				window.location.href = path;
			}, 1000);
		} else {
			candidateErrorModal.append(Icon());
			candidateErrorModal.append(
				inputErrorFeedback(add.message, "danger")
			);
		}
		candidateError.modal("show");
		addCandidate.removeAttr("disabled").html(submitButtonContent);
	} catch (error) {
		console.error(error, error.responseText);
	}
};

let handleUpdateProfilePicture = async function () {
	let file = this.files[0];
	let { electionId: election, position } = $(this).parents("form").data();
	let imageElement = $(this)
		.parents(".candidate_select_wrapper")
		.find(".candidate_image");
	candidateErrorModal.empty();
	let { voterId: voter_id } = $(this).data();
	let data = new FormData();
	data.append("image", file);
	data.append("election", election);
	data.append("position", position);
	data.append("voter_id", voter_id);
	data.append("updateCandidateImage", true);
	try {
		let update = await $.ajax({
			type: "POST",
			url: "/src/request.php",
			data: data,
			dataType: "Json",
			contentType: false,
			processData: false,
			cache: false,
		});
		if (update.status == "success") {
			imageElement.attr({
				src: `/assets/images/candidate_images/${update.img}`,
			});
			candidateErrorModal.append(Icon("success"));
			candidateErrorModal.append(
				inputErrorFeedback(update.message, "success")
			);
		} else {
			candidateErrorModal.append(Icon());
			candidateErrorModal.append(
				inputErrorFeedback(update.message, "danger")
			);
		}
		candidateError.modal("show");
	} catch (error) {
		console.error(error, error.responseText);
	}
};

let handleDeleteCandidate = async function () {
	let { removeCandidate: candidateId, election, position } = $(this).data();
	// console.log(candidateId);
	$(this).attr("disabled", "disabled");
	let data = {
		voter_id: candidateId,
		election: election,
		position: position,
		deleteCandidate: true,
	};
	candidateErrorModal.empty();
	try {
		let add = await $.ajax({
			type: "POST",
			url: "/src/request.php",
			data: data,
			dataType: "Json",
		});
		if (add.status == "success") {
			candidateErrorModal.append(Icon("success"));
			candidateErrorModal.append(
				inputErrorFeedback(add.message, "success")
			);
			$(this).parents(".candidate_select_wrapper").remove();
		} else {
			candidateErrorModal.append(Icon());
			candidateErrorModal.append(
				inputErrorFeedback(add.message, "danger")
			);
		}
		candidateError.modal("show");
	} catch (error) {
		console.error(error, error.responseText);
	}
};

$(".detail-wrapper").on("click", handleCandidateSelected);
$("#searchCandidate").on("input", handleCandidateSearch);
$("#addCandidateForm").on("submit", handleAddCandidate);
$("#listCandidateForm").on("submit", (e) => e.preventDefault());
$(".candidate_image_input").on("change", handleUpdateProfilePicture);
$(".btn[data-remove-candidate]").on("click", handleDeleteCandidate);
$(".total-candidate span").text(totalCandidates);
