$(window).on("click", function (e) {
	$(".admin-header .my-dropdown").removeClass("drop");
	$(".admin-sidebar").removeClass("open");
});

$(window).on("scroll", () => handleBackToTop());
$(window).on("load", () => handleBackToTop());

handleBackToTop = function () {
	let scrollHeight = 200;
	let scrollTop = $(document).scrollTop();
	$("#backToTop").toggleClass("open", scrollTop >= scrollHeight);
	$(".landing-header").toggleClass("scrolled", scrollTop >= scrollHeight);
};

$("#backToTop").on("click", function () {
	$(document).scrollTop(0);
});

// This is the events for when the landing page navbar toggle ic clicked
$(".landing-header .hamburger").on("click", function () {
	let header = $(this).parents(".landing-header");
	let right = header.find(".right");
	let height = right.find(".links-group")[0].clientHeight;
	$(this).toggleClass("open", !$(this).hasClass("open"));
	right.toggleClass("open", !right.hasClass("open"));
	right.hasClass("open")
		? right.css({ "--height": height + "px" })
		: right.css({ "--height": "0px" });
});

//This is the events that handle the hide and show of password fields
$(".floating_form .show").on("click", function () {
	let field = $($(this).siblings("input"));
	let type = field.prop("type");
	let me = $(this);
	let handleShow = (className, type) => {
		field.prop({ type: type });
		me.html(`<i class="fa ${className}"></i>`);
	};
	type == "password"
		? handleShow("fa-eye-slash", "text")
		: handleShow("fa-eye", "password");
});

// This is the events thst handles the dropdown of the administrators page header || navbar
$(".admin-header .my-dropdown-toggle").on("click", function (e) {
	let parent = $(this).parent();
	parent.toggleClass("drop");
});

//This events prevents propagation if the dropdown is clicked to prevent it from closing
$(".admin-header .my-dropdown").on("click", function (e) {
	e.stopPropagation();
});

// This is the events handles the dropdown available at the sidebar of the administrators page
$(".admin-sidebar .my-dropdown-toggle").on("click", function (e) {
	let parent = $(this).parent();
	parent.siblings(".my-dropdown").each((i, el) => {
		$(el).removeClass("open");
		$(el).css({ "--height": 0 });
	});
	let height = parent.hasClass("open")
		? 0
		: parent.find(".wrapper")[0].scrollHeight;
	parent.toggleClass("open");
	parent.css({ "--height": `${height}px` });
});

// This is the event that closes te sidebar of the administrators page
$(".admin-sidebar .close").on("click", function () {
	$(".admin-sidebar").removeClass("open");
});

//This events stops the propagation of the sidebar when clicked
$(".admin-sidebar").on("click", function (e) {
	e.stopPropagation();
});

// This is the events that toggles the sidebar of the administrator's page on mobile screen
$(".admin-header .open").on("click", function (e) {
	e.stopPropagation();
	$(".admin-sidebar").toggleClass(
		"open",
		!$(".admin-sidebar").hasClass("open")
	);
});

// This is the events that handles the datatables in most of the pages where tables are used to present data.
$("#memberList").DataTable({ responsive: true });
