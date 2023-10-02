//for single selection


$(document).ready(function() {

    const emoji_picker_m = document.querySelector('#emoji-picker_m');
    let pickerVisible_m = false;
    let picker_m;

    emoji_picker_m.addEventListener('click', function() {
        if (!pickerVisible_m) {




            pickerVisible_m = true;
            showPickerAtButton_m();
        } else {
            hidePicker_m();
            pickerVisible_m = false;
        }
    });

    function showPickerAtButton_m() {

        const pickerOptions_m = {
            onEmojiSelect: function(emoji) {
                console.log( emoji.native);

                var parentElement = document.getElementById(selected_text_id);

                // Find and update elements with class "ml-2" inside the parent element
                var ml2Elements = parentElement.querySelectorAll('.ml-2');

                ml2Elements.forEach(function(element) {


                    element.innerHTML = emoji.native;
                });

            },
        };
        picker_m = new EmojiMart.Picker(pickerOptions_m);

        const rect = emoji_picker_m.getBoundingClientRect();
        const top = window.scrollY + rect.bottom;
        const left = window.scrollX + rect.left;
        picker_m.style.position = 'absolute';
        picker_m.style.top = top + 'px';
        picker_m.style.left = left + 'px';
        document.body.appendChild(picker_m);


    }

    function hidePicker_m() {
        if (picker_m && picker_m.parentNode) {


            document.body.removeChild(picker_m);
        }
    }
});

//for icons
// Function to create the icon grid
function createIconGrid2_multiple() {
    const leftIconGrid_multiple = document.querySelector(".leftIconGrid_multiple");
    let iconRow = '';
    for (let i = 0; i < icons.length; i++) {
        iconRow += `
<div class="col-md-6">
<i class="${icons[i]}" onclick="changeRightIcon_single('${icons[i]}')"></i>
</div>
`;
    }

    leftIconGrid_multiple.innerHTML = '<div class="row">' + iconRow + '</div>';
}
// Call the function to create the icon grid
createIconGrid2_multiple();

// Function to filter icons based on search input
function filterIcons2_multiple() {
    const input = document.querySelector(".iconSearch_multiple");
    const filter = input.value.trim().toUpperCase();
    const icons = document.querySelectorAll(".leftIconGrid_multiple i");

    icons.forEach((icon, index) => {
        const iconName = icon.getAttribute("class");
        const col = icon.parentElement;

        if (iconName.toUpperCase().indexOf(filter) > -1) {
            col.style.display = "inline-block";
        } else {
            col.style.display = "none";
        }
    });
}

// Attach event listener to the search input
const searchInput2_multiple = document.querySelector(".iconSearch_multiple");
searchInput2_multiple.addEventListener("input", filterIcons2_multiple);




function add_multi_selection(){
    const addColumnButtons = document.querySelectorAll('.multi_plus');
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
<div id="image_${Math.random()}" class="multi_selection_open custom_column margen_non col-lg-12 col-xlg-12 col-md-12">
<div class="d-flex align-items-center">
<div class="mr-2">
<input class="" type="checkbox" value="" id=""> 
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

            multi_selection_open_run();
        };

        button.addEventListener('click', button.clickListener);
    });




}
add_multi_selection();


//


//

var multi_selection_open = document.getElementsByClassName("multi_selection_open");


var show_tools_multi_selection = function() {
    open_ideal();
    var attribute = this.getAttribute("data-myattribute");
    var id_is = this.id;
    selected_text_id = id_is;


    just_hide_leftpage();
    alltools('for_only_multi_selection');


    console.log(selected_text_id);





};
multi_selection_open_run();
function multi_selection_open_run() {
    for (var i = 0; i < multi_selection_open.length; i++) {
        multi_selection_open[i].addEventListener('click', show_tools_multi_selection, false);


    }
}

