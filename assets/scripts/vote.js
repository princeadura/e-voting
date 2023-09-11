let fields = $(".positions-wrapper");
let select = fields.find(".select-candidate");
let selectedCandidateElement = $(".selected-candidate");

let handleChangingCandidate = function () {
	let value = $(this).val();
	let img;
	if (value == "") {
		img = "default.png";
	} else {
		let option = $(this).find(`option[value="${value}"]`);
		img = option.data("img");
		img = img != "" ? img : "default.png";
	}
	$(this)
		.parents(".candidate")
		.find(".top")
		.children(".candidate-image")
		.attr({ src: `/assets/images/candidate_images/${img}` });

	let votes = [...select].map((vote) => $(vote).val());
	if (votes.some((vote) => vote == "")) {
		$("#confirmVoteButton").prop({ disabled: true });
		return;
	}
	$("#confirmVoteButton").prop({ disabled: false });
};

let handleConfirmVote = function () {
	let voteCount = [...select].map((vote) => $(vote).val());
	if (!voteCount.every((vote) => vote != "")) return;
	let positions = [...select].map((pos) => {
		let voted = $(pos).val();
		let candidateName = $(pos).find(`option[value=${voted}]`).text().trim();
		return [$(pos).prop("name"), candidateName];
	});
	selectedCandidateElement.empty();
	positions.forEach((pos) => {
		selectedCandidateElement.append(`
			<li class="list-group-item">
				<span class="post">${pos[0]}: </span>
				<span class="candidate">${pos[1]}</span>
			</li>
		`);
	});
	$("#confirmVote").modal("show");
};

let handleVote = function (e) {
	e.preventDefault();
	let { election } = fields.data();
	let votingPin = this.voting_pin.value;
	this.voting_pin.value = "";
	this.vote.disabled = true;
	let data = new FormData(fields[0]);
	data.append("voting_pin", votingPin);
	data.append("election_id", election);
	console.log(data);
};
$("#checkVote").on("click", function () {
	$(this).parents(".modal").modal("hide");
	$("#checkVotingPin").modal("show");
});
$("#votingPin").on("input", function () {
	let value = $(this).val();
	if (value.length == 4 && !isNaN(value)) {
		$(this).parent().next().prop("disabled", false);
	} else {
		$(this).parent().next().prop("disabled", true);
	}
});

$(".select-candidate").on("change", handleChangingCandidate);
$("#confirmVoteButton").on("click", handleConfirmVote);
$("#voting").on("submit", handleVote);