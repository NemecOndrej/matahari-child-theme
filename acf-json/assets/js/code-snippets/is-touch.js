/*ěščřžýáíéúů*/

// returns true if current device has touch capability
function isTouchDevice() {
    return 'ontouchstart' in document.documentElement
            || (navigator.MaxTouchPoints > 0)
            || (navigator.msMaxTouchPoints > 0);
}