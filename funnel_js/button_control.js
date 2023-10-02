var open_button = document.getElementsByClassName("open_button");
//button change color
document.getElementById("favcolor_button").addEventListener("input", function() {


    var  myDiv   = document.getElementById(selected_text_id);
    const buttonsInDiv = myDiv.getElementsByTagName('a');
    buttonsInDiv[0].style.backgroundColor = this.value;
     buttonsInDiv[0].style.borderColor = this.value; 
    
    console.log(buttonsInDiv[i]);


});
//button text change color
document.getElementById("favcolor_button_text").addEventListener("input", function() {
    console.log(this.value);
    var  myDiv   = document.getElementById(selected_text_id);
    const buttonsInDiv = myDiv.getElementsByTagName('a');
    buttonsInDiv[0].style.color =  this.value;



});

var show_tools_button = function() {
    var attribute = this.getAttribute("data-myattribute");
    var id_is = this.id;

    open_ideal();

    selected_text_id = id_is;
    just_hide_leftpage();
    alltools('for_only_buuton');

    const divElement = document.getElementById(selected_text_id);
    const aElement = divElement.querySelector('a');
    const aComputedStyle = window.getComputedStyle(aElement);
    const aBgColor = aComputedStyle.backgroundColor;
    const aTextColor = aComputedStyle.color;
    document.getElementById("favcolor_button").value = rgbToHex(aBgColor);
    document.getElementById("favcolor_button_text").value = rgbToHex(aTextColor);


    //for alogment 
    const textAlign = aComputedStyle.getPropertyValue("text-align");
   
    get_alignment(textAlign)

    //for goto page
    const onclickAttributeValue = aElement.getAttribute("onclick");
    const parameterValue = onclickAttributeValue.match(/\('([^']+)'\)/)[1];
    const dropdowns = document.querySelectorAll(".dropdown_goto");
    dropdowns.forEach(function (dropdown) {
        const selectedOptionId = null; 
        updateDropdown(dropdown, parameterValue.toString());
    });


};
button_open_run();
function button_open_run() {
    for (var i = 0; i < open_button.length; i++) {
        open_button[i].addEventListener('click', show_tools_button, false);
       

    }
}