export function Faq() {
	let section = $(`
       <section class="faq">
	   <img src="/assets/images/faq.svg" alt="" class="faq-img" srcset="" />
	   		<div class="container">
			   <h2 class="faq-title">Frequently Asked Questions ??</h2>
			</div>
       </section>
    `);
	section.find(".container").append(accordion());
	return section;
}

function accordion() {
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
	let accordion = ({ index }) =>
		$(`
        <div class="my-accordion">
            <button type="button" class="my-accordion-head"> 
                <h3 class="my-accordion-title m-0">Title </h3> 
                <span class="icon">
                    <i class="fas fa-angle-down"></i>
                </span>
            </button>
            <div class="my-accordion-body">
                <div class="my-accordion-content">
                    <h5> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Mollitia magnam tenetur praesentium libero aut quo repellendus iure est dicta, quae maxime culpa velit in, accusantium eaque tempora omnis soluta, vitae dolores dolorem aspernatur rem! ${
						index % 2 == 0 &&
						"tur praesentium libero aut quo repellendus iure est dicta, quae maxime culpa velit in, accusantium eaque tempora omnis soluta, vitae dolores do"
					}  </h5>
                </div>
            </div>
        </div>
    `);
	for (let index = 0; index < 5; index++) {
		accordions.append(accordion({ index }));
	}
	accordions
		.find(".my-accordion .my-accordion-head")
		.on("click", handleClick);
	return accordions;
}
