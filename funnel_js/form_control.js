var form_open = document.getElementsByClassName("form_open");
//button change color
document.getElementById("favcolor_button_form").addEventListener("input", function() {


    var  myDiv   = document.getElementById(selected_text_id);
    const buttonsInDiv = myDiv.getElementsByTagName('a');
    buttonsInDiv[1].style.backgroundColor = this.value;;
    console.log(buttonsInDiv[i]);


});
//button text change color
document.getElementById("favcolor_button_text_form").addEventListener("input", function() {
    console.log(this.value);
    var  myDiv   = document.getElementById(selected_text_id);
    const buttonsInDiv = myDiv.getElementsByTagName('a');
    buttonsInDiv[1].style.color =  this.value;



});

var show_tools_form = function() {

    var attribute = this.getAttribute("data-myattribute");
    var id_is = this.id;

    open_ideal();

    selected_text_id = id_is;
    just_hide_leftpage();
    alltools('for_only_form');

    const divElement = document.getElementById(selected_text_id);
    const aElement = divElement.querySelectorAll('a');
    if (aElement.length > 0) {
        const lastAElement = aElement[aElement.length - 1];

        const aComputedStyle = window.getComputedStyle(lastAElement);
        const aBgColor = aComputedStyle.backgroundColor;
        const aTextColor = aComputedStyle.color;
        document.getElementById("favcolor_button_form").value = rgbToHex(aBgColor);
        document.getElementById("favcolor_button_text_form").value = rgbToHex(aTextColor);

        //for goto page
        const onclickAttributeValue = lastAElement.getAttribute("onclick");
        const parameterValue = onclickAttributeValue.match(/\('([^']+)'\)/)[1];
        const dropdowns = document.querySelectorAll(".dropdown_goto");
        dropdowns.forEach(function (dropdown) {
            const selectedOptionId = null; 
            updateDropdown(dropdown, parameterValue.toString());
        });
    } else {
        console.error('There are not enough  elements in the div.');
    }








};
form_open_run();
function form_open_run() {
    for (var i = 0; i < form_open.length; i++) {
        form_open[i].addEventListener('click', show_tools_form, false);
    }
}