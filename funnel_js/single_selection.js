function add_single_selection(){
    const addColumnButtons = document.querySelectorAll('.single_plus');
    addColumnButtons.forEach(button => {
        button.removeEventListener('click', button.clickListener);
    });
    // Add new click listeners to the same elements
    addColumnButtons.forEach(button => {
        button.clickListener = () => {
            const tabContent = button.parentElement; // Get the tab content
            const newColumnContainer = document.createElement('div');
            newColumnContainer.classList.add('col-lg-6', 'col-xlg-6', 'col-md-6', 'text-center', 'padding_non', 'margen_non', 'draggable');
            newColumnContainer.draggable = true;

            const newColumnContent = `
<div class="custom_container row defalte_bg draggable" draggable="true">
<div class="delete-button" onclick="deleteRow(this)">Delete</div>
<div id="image_${Math.random()}" class="single_selection_open custom_column margen_non col-lg-12 col-xlg-12 col-md-12">
<div class="d-flex align-items-center">
<div class="mr-2">
<i class="fas fa-2x fa-angle-right"></i> <!-- Small Icon -->
</div>
<div contenteditable="true" class="flex-grow-1" style="text-align: left">
<p class="m-0">New Column</p> <!-- Text Element -->
</div>
<div class="ml-2 single_selection_icon">
<i class="fas  fa-thumbs-down"></i> <!-- Big Icon -->
</div>
</div>
</div>
</div>`;

            newColumnContainer.innerHTML = newColumnContent;
            tabContent.insertBefore(newColumnContainer, button);

            single_selection_open_run();
        };

        button.addEventListener('click', button.clickListener);
    });




}
add_single_selection();


//

// Function to change the right icon
function changeRightIcon_single(iconClass) {
    // Select the element with ID "image_2.90332"
    var parentElement = document.getElementById(selected_text_id);

    // Find and update elements with class "ml-2" inside the parent element
    var ml2Elements = parentElement.querySelectorAll('.ml-2');

    ml2Elements.forEach(function(element) {


        element.innerHTML = '<i class="fas ' + iconClass + '"></i>';
    });
}

//

var single_selection_open = document.getElementsByClassName("single_selection_open");


var show_tools_single_selection = function() {
    open_ideal();
    var attribute = this.getAttribute("data-myattribute");
    var id_is = this.id;
    selected_text_id = id_is;


    just_hide_leftpage();
    alltools('for_only_single_selection');
    console.log(selected_text_id);


    //go to the page

    var divElement = document.getElementById(selected_text_id);
    var onclickValue = divElement.getAttribute("onclick");
    var parameterValue = onclickValue.match(/\('([^']+)'\)/)[1];
    const dropdowns = document.querySelectorAll(".dropdown_goto");
    dropdowns.forEach(function (dropdown) {
        const selectedOptionId = null; 
        updateDropdown(dropdown, parameterValue.toString());
    });




};
single_selection_open_run();
function single_selection_open_run() {
    for (var i = 0; i < single_selection_open.length; i++) {
        single_selection_open[i].addEventListener('click', show_tools_single_selection, false);


    }
}

