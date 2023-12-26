/*ěščřžýáíéúů*/

// disable images download
$("body").on("mousedown", "img, [data-background]", function (e) {
	// right click
	if (e.button == 2) {
		e.preventDefault();
		return false;
	}
});
$("body").on("contextmenu", "img, [data-background]", function (e) {
	return false;
});