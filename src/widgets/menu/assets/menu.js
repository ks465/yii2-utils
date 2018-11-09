/**
 * @package app\widgets\menu
 * @author Keyhan Sedaghat <keyhansedaghat@netscape.net>
 * @copyright KHanS 2018
 * @version 0.1.0-970717
 */

// Slide in from the side
/* Open when someone clicks on the span element */
function khanMenuOpenNav() {
    document.getElementById("KHanOverlayMenu").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function khanMenuCloseNav() {
    document.getElementById("KHanOverlayMenu").style.width = "0%";
}

// -- ////////////////////////////////////////////////////////////////

// Slide down from the top
/* Open */
// function khanMenuOpenNav() {
//     document.getElementById("KHanOverlayMenu").style.height = "100%";
// }

/* Close */
// function khanMenuCloseNav() {
//     document.getElementById("KHanOverlayMenu").style.height = "0%";
// }

// -- ////////////////////////////////////////////////////////////////

// Open the menu without animation
/* Open */
// function khanMenuOpenNav() {
//     document.getElementById("KHanOverlayMenu").style.display = "block";
// }

/* Close */
// function khanMenuCloseNav() {
//     document.getElementById("KHanOverlayMenu").style.display = "none";
// }

// -- ////////////////////////////////////////////////////////////////
