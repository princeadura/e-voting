export async function Faq() {
	let section = $(`
       <section class="faq">
	   <img src="/assets/images/faq.svg" alt="" class="faq-img" srcset="" />
	   		<div class="container">
			   <h2 class="faq-title">Frequently Asked Questions ??</h2>
			</div>
       </section>
    `);
	section.find(".container").append(await accordion());
	return section;
}

async function accordion() {
	let handleClick = function () {
		let accordion = $(this).parents(".my-accordion");
		accordion.siblings().each((i, el) => {
			$(el).find(".my-accordion-body").css({ "--height": `0px` });
			$(el).removeClass("open");
		});
		accordion.toggleClass("open", !accordion.hasClass("open"));
		let height = accordion.hasClass("open")
			? accordion.find(".my-accordion-content")[0].clientHeight
			: 0;
		accordion.find(".my-accordion-body").css({ "--height": `${height}px` });
	};
	let accordions = $(`<div class="my-accordions"></div>`);
	let accordionElment = ({ question, answer }) =>
		$(`
        <div class="my-accordion">
            <button type="button" class="my-accordion-head"> 
                <h3 class="my-accordion-title m-0"> ${question} </h3> 
                <span class="icon">
                    <i class="fas fa-angle-down"></i>
                </span>
            </button>
            <div class="my-accordion-body">
                <div class="my-accordion-content">
                    <h5> ${answer} </h5>
                </div>
            </div>
        </div>
    `);
	let questions = await $.get("/assets/scripts/content/faq.json");
	questions.forEach((question) => {
		accordions.append(accordionElment(question));
	});
	accordions
		.find(".my-accordion .my-accordion-head")
		.on("click", handleClick);
	return accordions;
}
