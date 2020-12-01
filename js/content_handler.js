var states = {};

function openVod(index) {
    // Check if opened
    if (states[index]) {
        // Close
        states[index] = false;
        $("#spoiler-content-" + index).hide(200);
        $("#spoiler-button-" + index).toggleClass("rotate");
        $("#spoiler-button-" + index).toggleClass('rotate-reset');
    } else {
        states[index] = true;
        $("#spoiler-content-" + index).show(200);
        $("#spoiler-button-" + index).toggleClass("rotate");
        $("#spoiler-button-" + index).toggleClass('rotate-reset');
    }
}