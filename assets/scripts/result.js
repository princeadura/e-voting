let controls = [...$(".result-wrapper .controls .btn")];
let display = [...$(".result-wrapper .display_wrapper > div")];
let positions = [...$(".result-wrapper .position .position_toggle")];
let chartReload = $(".result-wrapper .reload-chart");

let preload = () => {
	let loader = ` <div class="preload"><img src="/assets/images/loading.gif"alt=""srcset=""/></div>`;
	$(".chart-wrapper .preload").remove();
	return loader;
};

let loadChart = () => {
	let index = controls.findIndex((control) => $(control).hasClass("active"));
	handleResultToggle({ index });
};

$(window).on("load", () => {
	loadChart();
});

chartReload.on("click", () => {
	loadChart();
});

function getRandomColorArray(array) {
	let colorArray = [];

	for (let i = 0; i < array.length; i++) {
		let randomNumber = Math.random();
		colorArray.push(
			`#${Math.floor(randomNumber * 0xffffff)
				.toString(16)
				.padStart(6, "0")}`
		);
	}

	return colorArray;
}

let handlePositionChart = async ({ post, election }) => {
	$(".chart-wrapper").prepend(preload);

	try {
		let data = {
			position: post,
			election: election,
			getVotes: true,
		};

		let votes = await $.post("/src/request.php", data, null, "json");

		$(".chart-wrapper .result-title").text(`${post} Position Result`);

		$(".chart-wrapper .chart").empty();

		const canvas = document.createElement("canvas");
		document.querySelector(".chart-wrapper .chart").appendChild(canvas);

		let message = votes.message;

		let names = message.map((msg) => `${msg.firstname} ${msg.lastname}`);

		let candidateVotes = message.map((msg) => `${msg.votes}`);

		new Chart(canvas, {
			type: "doughnut",
			data: {
				labels: names,
				datasets: [
					{
						label: "Votes",
						data: candidateVotes,
						backgroundColor: getRandomColorArray(names),
						hoverOffset: 4,
					},
				],
			},
		});

		$(".chart-wrapper .preload").remove();
	} catch (error) {
		console.error(error);
		console.error(error.responseText);
	}
};

let handlePositionWinners = async ({ election }) => {
	$(".table-wrapper").prepend(preload);
	$(".table-wrapper tbody").empty();
	try {
		let data = {
			election: election,
			getElectionWinners: true,
		};

		let winners = await $.post("/src/request.php", data, null, "json");

		let messages = winners.message;

		let tableRow = function ({
			index,
			firstname,
			lastname,
			email,
			position,
			votes,
		}) {
			let row = $(`
			<tr>
				<td>${++index}.</td>
				<td>${firstname}</td>
				<td>${lastname}</td>
				<td>${email}</td>
				<td>${position}</td>
				<td>${votes}</td>
			</tr>
			`);
			return row;
		};

		$.each(messages, function (index, message) {
			$(".table-wrapper tbody").append(tableRow({ ...message, index }));
		});

		$(".table-wrapper .preload").remove();
	} catch (error) {
		console.error(error);
		console.error(error.responseText);
	}
};

let handleResultToggle = ({ index }) => {
	let button = $(controls[index]);
	let { action } = button.data();

	let { election } = $(".display_wrapper").data();

	if (action == "chart") {
		let activeButton = positions.filter((position) =>
			$(position).hasClass("active")
		);
		let { post } = $(activeButton).data();
		handlePositionChart({ post, election });
	} else {
		handlePositionWinners({ election });
	}

	let target = $(display[index]);
	display.map((view) => $(view).removeClass("active"));
	target.addClass("active");
};

controls.forEach((control) => {
	control.addEventListener("click", () => {
		let controlButton = $(control);
		let isActive = controlButton.hasClass("active");
		if (isActive) return;

		controls.map((ctrl) => $(ctrl).removeClass("active"));
		$(control).addClass("active");
		loadChart();
	});
});

positions.forEach((position) => {
	position.addEventListener("click", () => {
		let me = $(position);
		let isActive = me.hasClass("active");
		if (isActive) return;

		positions.map((post) => $(post).removeClass("active"));
		me.addClass("active");
		loadChart();
	});
});
