function updateDropdown(dropdown, selectedOptionId) {
    const questionItems = document.querySelectorAll(".question-list li");
    const options = [];
    if(selectedOptionId == 'thanks'){
        selectedOptionId = 'thanks_1';
    }
    if(selectedOptionId == 'disqualification'){
        selectedOptionId = 'disqualification_1';
    }
    dropdown.innerHTML = ''; // Clear existing options

    // Create and add options with IDs starting from 1
    questionItems.forEach(function (item, index) {
        const spanText = item.querySelector("span").textContent;
        const option = document.createElement("option");
        option.value = spanText;
        option.textContent = spanText;
        option.id = (index + 1).toString(); // IDs start from 1

        options.push(option);
        dropdown.appendChild(option);
    });



    // Add the last two options with fixed IDs
    const formOption = document.createElement("option");
    formOption.value = "copy_paste";
    formOption.textContent = "Copy URL";
    formOption.id = "copy_paste";
    options.push(formOption);
    dropdown.appendChild(formOption);


    // Modify the IDs of the last two options
    const secondLastOption = options[options.length - 3];
    const lastOption = options[options.length - 2];


    secondLastOption.id = "thanks_1"; 
    lastOption.id = "disqualification_1";

    // Set the selected option based on the ID
    options.forEach(function (option) {
        if (option.id === selectedOptionId) {
            option.selected = true;
        }
    });

    // Add an onchange event handler to the select element
    dropdown.onchange = function() {
        const selectedOption = dropdown.options[dropdown.selectedIndex];
        const selectedOptionId = selectedOption.getAttribute("id");
        const selectedOptionValue = selectedOption.value;

        handleOptionChange(selectedOptionId, selectedOptionValue, dropdown);
    };
}

// Function to handle option changes
function handleOptionChange(selectedOptionId, selectedOptionValue, dropdown) {
    console.log("Dropdown:", dropdown, "Option ID:", selectedOptionId, "Value:", selectedOptionValue);


    if(selectedOptionId == 'thanks_1'){
        selectedOptionId = 'thanks';
    }
    if(selectedOptionId == 'disqualification_1'){
        selectedOptionId = 'disqualification';
    }
    // Update the onclick attribute of the anchor element inside the dropdown's parent
    const divElement = document.getElementById(selected_text_id);

    if (divElement.classList.contains("single_selection_open")) {
        const newParameter = selectedOptionId.toString(); 

        console.log(newParameter)
        divElement.setAttribute("onclick", "showAnswer_20('" + newParameter + "')");
    }else {

        const aElement = divElement.querySelector('a');
        const newParameter = selectedOptionId.toString(); 
        aElement.setAttribute("onclick", "showAnswer_20('" + newParameter + "')");
    }
}

const dropdowns = document.querySelectorAll(".dropdown_goto");
dropdowns.forEach(function (dropdown) {
    const selectedOptionId = null; 
    updateDropdown(dropdown, selectedOptionId);
});
