var text_open = document.getElementsByClassName("text_open");
document.getElementById("favcolor").addEventListener("input", function() {

    document.getElementById(selected_text_id).style.color = this.value;

});
var show_tools_text = function() {
    open_ideal();
    var attribute = this.getAttribute("data-myattribute");
    var id_is = this.id;
    selected_text_id = id_is;

    const divElement = document.getElementById(selected_text_id);
    const computedStyle = window.getComputedStyle(divElement);
    const textColor = computedStyle.color;
    document.getElementById("favcolor").value = rgbToHex(textColor);
    just_hide_leftpage();
    alltools('for_only_text');


    let this_font_size = computedStyle.getPropertyValue("font-size");

    let numberValue = parseInt(this_font_size);
    const size_is = document.getElementById("size_is");
    size_is.value=numberValue;

    console.log(this_font_size);
    //for alogment 
    const textAlign = computedStyle.getPropertyValue("text-align");
    console.log(textAlign);
    get_alignment(textAlign)





    //style

    const bold_1 = document.querySelectorAll('.bold_1');
    const italian_1 = document.querySelectorAll('.italian_1');
    const line_1 = document.querySelectorAll('.line_1');



    var selected_text_id_is = document.getElementById(selected_text_id);


    if (computedStyle.getPropertyValue("font-weight")) {
        const font_weight = computedStyle.getPropertyValue("font-weight");

        if(font_weight === "bold" || parseInt(font_weight) >= 700){
            bold_1.forEach(element => {
                element.classList.add('selected_alignment');
            });
        }else{
            bold_1.forEach(element => {
                element.classList.remove('selected_alignment');
            });

        }

        console.log("Font Weight:", font_weight);
    } else {
        console.log("Font weight property not found.");

        bold_1.forEach(element => {
            element.classList.remove('selected_alignment');
        });
    }

    if (computedStyle.getPropertyValue("font-style")) {
        const font_style = computedStyle.getPropertyValue("font-style");

        if (font_style === "italic") {
            italian_1.forEach(element => {
                element.classList.add('selected_alignment');
            });
        } else {
            italian_1.forEach(element => {
                element.classList.remove('selected_alignment');
            });

        }


        selected_text_id_is.style.textAlign = 'center';


        console.log("Font Style:", font_style);
    } else {

        italian_1.forEach(element => {
            element.classList.remove('selected_alignment');
        });

        console.log("Font Style property not found.");
    }

    if (computedStyle.getPropertyValue("text-decoration")) {
        const  text_decoration = computedStyle.getPropertyValue("text-decoration");


        if (text_decoration.includes("underline")) {
            line_1.forEach(element => {
                element.classList.add('selected_alignment');
            });
        } else {
            line_1.forEach(element => {
                element.classList.remove('selected_alignment');
            });
        }



        console.log("Font decoration:", text_decoration);
    } else {


        line_1.forEach(element => {
            element.classList.remove('selected_alignment');
        });
        console.log("Font decoration property not found.");
    }

    //    font-weight: bold; font-style: italic; text-decoration: underline;
    //styles



};
text_open_run();
function text_open_run() {
    for (var i = 0; i < text_open.length; i++) {
        text_open[i].addEventListener('click', show_tools_text, false);


    }
}



const size_is = document.getElementById('size_is');
size_is.addEventListener('input', () => {
    var pxis =   size_is.value



    var selected_text_id_is = document.getElementById(selected_text_id);
    selected_text_id_is.style.fontSize = pxis+'px'; 
});



function chnage_style(what){

    const bold_1 = document.querySelectorAll('.bold_1');
    const italian_1 = document.querySelectorAll('.italian_1');
    const line_1 = document.querySelectorAll('.line_1');

    var selected_text_id_is = document.getElementById(selected_text_id);
    const computedStyle = getComputedStyle(selected_text_id_is);

    const font_weight = computedStyle.getPropertyValue("font-weight");
    const font_style = computedStyle.getPropertyValue("font-style");
    const  text_decoration = computedStyle.getPropertyValue("text-decoration");


    if(what == "bold"){

        if (font_weight === "bold" || parseInt(font_weight) >= 700) {
            selected_text_id_is.style.fontWeight = "normal"; 

            bold_1.forEach(element => {
                element.classList.remove('selected_alignment');
            });



        } else {
            selected_text_id_is.style.fontWeight = "bold"; 


            bold_1.forEach(element => {
                element.classList.add('selected_alignment');
            });

        }

    }
    if(what == "italian"){

        if (font_style === "italic") {

            italian_1.forEach(element => {
                element.classList.remove('selected_alignment');
            });
            selected_text_id_is.style.fontStyle  = 'normal';
        } else {

            italian_1.forEach(element => {
                element.classList.add('selected_alignment');
            });


            selected_text_id_is.style.fontStyle  = 'italic';
        }
    }
    if(what == "line"){
        if (text_decoration.includes("underline")) {

            line_1.forEach(element => {
                element.classList.remove('selected_alignment');
            });
            selected_text_id_is.style.textDecoration = "none"; 

        } else {


            line_1.forEach(element => {
                element.classList.add('selected_alignment');
            });


            selected_text_id_is.style.textDecoration = "underline"; 
        }


    }

}