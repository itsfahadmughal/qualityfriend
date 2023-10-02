//pages list
//var pages = ["Advantages", "Company / Tasks", "1. Question: Do you have experience in the field of XY?","2. Question: What is important to you in a new job?",`3. Question: How many years of work experience do you have?`,`4. Question: Describe yourself in three or four short sentences?`,`5. Question: When could you start with us?
//`,`6. Upload CV`,`7. When is the earliest we can reach you?`,`Data Entry`];

console.log(pages);

//var pages = <?php echo $pages; ?>;
var    my_pages = document.getElementById("my_pages");

pages_list();
function pages_list(){
    my_pages.innerHTML = "";
    for (let i = 0; i < pages.length; i++) {
        var page_ref = "page_"+i;
        if(i == 0){
            var active = "active";
        }else {
            var active = "";
        }
        var page_is  = i + 1;
        my_pages.innerHTML +=  `<li  class="`+active+` mt-3">

<div class="row margen_non padding_non">
<div onclick="showAnswer(`+page_is+`)" class="col-lg-11 col-xlg-11 col-md-11">
<span>`+pages[i]+` </span>
</div>
<div class="col-lg-1 col-xlg-1 col-md-1">
<button  id='`+i+`' onclick='update_page_list(`+i+`)' type='button' class='close close-center1'  aria-hidden='true'>×</button>
</div>
</div>
</li>`

    } 
}
function update_page_list(newdep_list){



    var removed = pages.splice(newdep_list,1);
    pages_list();

    // Get the answer element corresponding to the question index
    var answerElement = document.getElementById(`answer-${newdep_list + 1}`);

    // Remove the answer element
    if (answerElement) {
        answerElement.remove();
    }

    // Update the remaining answer elements' IDs to match the new order
    var answerContainer = document.getElementById("all_the_anwer");
    var answerElements = answerContainer.querySelectorAll(".answer");

    answerElements.forEach(function (element, i) {
        if (element.id !== "disqualification" && element.id !== "thanks" && element.id !== "form_is") {
            element.id = `answer-${i + 1}`;
        }
    });


    question_li();
    const questionItems = document.querySelectorAll(".question-list li");
    questionItems.forEach(function (item, index) {
        item.classList.remove("active");

        if (index === newdep_list) {
            item.classList.add("active");
        } else {
            item.classList.remove("active");
        }


    });


}








function add_new_page() {
    let add_page = document.getElementById("add_page").value;
    pages.push(add_page);
    pages_list();
    document.getElementById("add_page").value = "";

    showAnswer(1);
    const questionItems = document.querySelectorAll(".question-list li");

    questionItems.forEach(function (item, index) {
        if (index === 0) {
            item.classList.add("active");
        } else {
            item.classList.remove("active");
        }
    });




    //add div 

    // Get the answer container element
    const answerContainer = document.getElementById("all_the_anwer");

    // Count child elements with IDs starting with "answer-"
    const answerCount = Array.from(answerContainer.children).filter(element =>
                                                                    element.id.startsWith("answer-")
                                                                   ).length;

    // Create a new div element for the answer
    const newAnswerDiv = document.createElement("div");

    // Set the ID for the new answer div
    const newDivId = `answer-${answerCount + 1}`;
    newAnswerDiv.setAttribute("id", newDivId);
    newAnswerDiv.classList.add("answer", "mb-4");

    // Create the inner content structure for the new answer div
    newAnswerDiv.innerHTML = `
<div class="dropzone rows-container" id="" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="drop(event)">
<div class="row margen_non  draggable" draggable="true">
<div id="" class="col-lg-12 col-xlg-12 col-md-4">
<!-- Inner content here -->
</div>
</div>
<div class="drop-indicator"></div>
</div>
`;

    // Find the last answer- div
    let lastAnswerDiv = null;
    for (let i = answerCount; i >= 1; i--) {
        lastAnswerDiv = answerContainer.querySelector(`#answer-${i}`);
        if (lastAnswerDiv) {
            break;
        }
    }

    // Insert the new answer div after the last answer- if it exists
    if (lastAnswerDiv) {
        answerContainer.insertBefore(newAnswerDiv, lastAnswerDiv.nextSibling);
    } else {
        // If no last answer- div exists, simply append the new answer div
        answerContainer.appendChild(newAnswerDiv);
    }












}


//Awnser
question_li();

function question_li(){

    // Get all question list items
    const questionItems = document.querySelectorAll(".question-list li");



    // Array to store references to event listener functions

    const eventListeners = [];
    eventListeners.forEach(function (listener, index) {
        questionItems[index].removeEventListener("click", listener);
    });
    // Add event listener to each question item
    // Add event listener to each question item
    questionItems.forEach(function (item, index) {
        const clickListener = function () {
            // Remove active class from all question items
            questionItems.forEach(function (item) {
                item.classList.remove("active");
            });

            // Add active class to the clicked question item
            item.classList.add("active");

            // Get the index of the clicked question
            const questionIndex = index + 1;



            // Call different functions based on index
            if (questionIndex === questionItems.length - 1) {
                showAnswer('thanks');
            } else if (questionIndex === questionItems.length ) {
                showAnswer('disqualification');
            } else {
                showAnswer(questionIndex);
            }
        };

        // Store the event listener function reference
        eventListeners.push(clickListener);

        // Add event listener to the item
        item.addEventListener("click", clickListener);
    });

}



function showAnswer(answerId) {

    selected_page = answerId;

    console.log(answerId);
    const answerContainers = document.querySelectorAll(".answer");
    answerContainers.forEach(function (container) {
        container.classList.remove("active");
    });
    if(answerId == "disqualification")
    {
        const selectedAnswer = document.getElementById(`disqualification`);
        selectedAnswer.classList.add("active");
        const questionItems = document.querySelectorAll(".question-list li");
        questionItems.forEach(function (item, index) {
            if (index === questionItems.length -1 ) {
                item.classList.add("active");
            } else {
                item.classList.remove("active");
            }
        });
    }else if(answerId == "thanks") {
        const selectedAnswer = document.getElementById(`thanks`);
        selectedAnswer.classList.add("active");


        const questionItems = document.querySelectorAll(".question-list li");
        questionItems.forEach(function (item, index) {
            if (index === questionItems.length - 2) {
                item.classList.add("active");
            } else {
                item.classList.remove("active");
            }
        });
    }
    else if(answerId == "form_is") {

    }
    else{

        const selectedAnswer = document.getElementById(`answer-${answerId}`);
        if (selectedAnswer !== null) {

            const questionItems = document.querySelectorAll(".question-list li");
            questionItems.forEach(function (item, index) {
                if (index === answerId-1) {
                    item.classList.add("active");
                } else {
                    item.classList.remove("active");
                }
            });
            selectedAnswer.classList.add("active");
        } else {
            const selectedAnswer = document.getElementById(`thanks`);
            selectedAnswer.classList.add("active");

            const questionItems = document.querySelectorAll(".question-list li");
            questionItems.forEach(function (item, index) {
                if (index === questionItems.length - 1) {
                    item.classList.add("active");
                } else {
                    item.classList.remove("active");
                }
            });
        }

    }

}