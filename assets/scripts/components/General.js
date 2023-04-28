export function loader() {
	return $(`
        <span class="loader">
            <i class="fas fa-spinner spin"></i>
            Loading...
        </span>
    `);
}

export function inputErrorFeedback(text, type) {
	return $(`
        <p class="text-${type} m-0 feedback">${text}</p>
    `);
}

export function alert(text, type) {
	let prefix = type == "danger" ? "OPPS" : "WOW";
	let alert = $(`
        <div class="alert alert-${type} alert-dismissible fade show " role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>${prefix}!!! </strong>${text}
        </div>
        
    `);
	setTimeout(() => alert.remove(), 1500);
	return alert;
}
