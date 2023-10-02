var cv_open = document.getElementsByClassName("cv_open");
//button change color
document.getElementById("favcolor_button_cv").addEventListener("input", function() {


    var  myDiv   = document.getElementById(selected_text_id);
    const buttonsInDiv = myDiv.getElementsByTagName('a');
    buttonsInDiv[0].style.backgroundColor = this.value;;
    console.log(buttonsInDiv[i]);


});
//button text change color
document.getElementById("favcolor_button_text_cv").addEventListener("input", function() {
    console.log(this.value);
    var  myDiv   = document.getElementById(selected_text_id);
    const buttonsInDiv = myDiv.getElementsByTagName('a');
    buttonsInDiv[0].style.color =  this.value;



});

var show_tools_cv = function() {

    var attribute = this.getAttribute("data-myattribute");
    var id_is = this.id;

    open_ideal();

    selected_text_id = id_is;
    just_hide_leftpage();
    alltools('for_only_cv');

    const divElement = document.getElementById(selected_text_id);
    const aElement = divElement.querySelector('a');
    const aComputedStyle = window.getComputedStyle(aElement);
    const aBgColor = aComputedStyle.backgroundColor;
    const aTextColor = aComputedStyle.color;
    document.getElementById("favcolor_button_cv").value = rgbToHex(aBgColor);
    document.getElementById("favcolor_button_text_cv").value = rgbToHex(aTextColor);

    //for goto page
    const onclickAttributeValue = aElement.getAttribute("onclick");
    const parameterValue = onclickAttributeValue.match(/\('([^']+)'\)/)[1];
    const dropdowns = document.querySelectorAll(".dropdown_goto");
    dropdowns.forEach(function (dropdown) {
        const selectedOptionId = null; 
        updateDropdown(dropdown, parameterValue.toString());
    });


};
cv_open_run();
function cv_open_run() {
    for (var i = 0; i < cv_open.length; i++) {
        cv_open[i].addEventListener('click', show_tools_cv, false);
    }
}