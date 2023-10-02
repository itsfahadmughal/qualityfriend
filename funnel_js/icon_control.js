var icon_open = document.getElementsByClassName("icon_open");
//icon change color
document.getElementById("favcolor_icon").addEventListener("input", function() {
    console.log(this.value);
    document.getElementById(selected_text_id).style.color = this.value;

});
// Function to change icon
function changeRightIcon(iconClass) {
    const rightIcon = document.getElementById(selected_text_id);
    rightIcon.innerHTML = `<i class="${iconClass}"></i>`;
}

var show_tools_icon = function() {
    var attribute = this.getAttribute("data-myattribute");
    var id_is = this.id;

    open_ideal();

    selected_text_id = id_is;
    just_hide_leftpage();

    alltools('for_only_icon');

    const divElement = document.getElementById(selected_text_id);
    const computedStyle = window.getComputedStyle(divElement);
    const textColor = computedStyle.color;
    document.getElementById("favcolor_icon").value = rgbToHex(textColor);


    let this_font_size = computedStyle.getPropertyValue("font-size");

    let numberValue = parseInt(this_font_size);
    const size_is_icon = document.getElementById("size_is_icon");
    size_is_icon.value=numberValue;

    //for alogment 
    const textAlign = computedStyle.getPropertyValue("text-align");
    console.log(textAlign);
    get_alignment(textAlign)
};
icon_open_run();
function icon_open_run() {
    for (var i = 0; i < icon_open.length; i++) {
        icon_open[i].addEventListener('click', show_tools_icon, false);
    }
}

const size_is_icon = document.getElementById('size_is_icon');
size_is_icon.addEventListener('input', () => {
    var pxis =   size_is_icon.value

    var selected_text_id_is = document.getElementById(selected_text_id);
    selected_text_id_is.style.fontSize = pxis+'px'; 
});
