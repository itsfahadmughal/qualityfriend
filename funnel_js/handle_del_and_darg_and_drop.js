// Function to handle hover and delete button visibility for all rows
$(".rows-container").on("mouseenter", ".row", function() {
    $(this).find('.delete-button').show();
    $(this).addClass("hovered-row");
}).on("mouseleave", ".row", function() {
    $(this).find('.delete-button').hide();
    $(this).removeClass("hovered-row");
});
var dropIndicator1 = "";



function allowDrop(event) {
    event.preventDefault();
    var dropzone = event.target.closest('.dropzone');

    if (dropzone) {
        dropIndicator1 = dropzone.querySelector('.drop-indicator');
        var targetRow = event.target.closest('.row');
        var targetColumn = event.target.closest('.col-lg-6, .col-lg-4, .col-lg-3, .col-lg-8'); // Assuming this class represents columns

        if (targetRow || targetColumn) {
            if (targetColumn) {
                // Get the width of the target column
                var columnWidth = targetColumn.offsetWidth;
                //                console.log(targetColumn);
                //
                //                console.log('col');
                // Get the midpoint of the target column
                var columnMidpoint = targetColumn.getBoundingClientRect().left + columnWidth / 2;

                // Position the drop indicator on the left or right based on the drag position
                if (event.clientX < columnMidpoint) {
                    dropIndicator1.style.left = targetColumn.getBoundingClientRect().left - dropzone.getBoundingClientRect().left + 'px';
                    dropIndicator1.style.right = '';
                } else {
                    dropIndicator1.style.right = dropzone.getBoundingClientRect().right - targetColumn.getBoundingClientRect().right + 'px';
                    dropIndicator1.style.left = '';
                }

                dropIndicator1.style.width = columnWidth + 'px';
            } else {



                // Get the width of the target column
                var columnWidth = targetRow.offsetWidth;



                // Get the midpoint of the target column
                var columnMidpoint = targetRow.getBoundingClientRect().left + columnWidth / 1;

                // Position the drop indicator on the left or right based on the drag position
                if (event.clientX < columnMidpoint) {
                    dropIndicator1.style.left = targetRow.getBoundingClientRect().left - dropzone.getBoundingClientRect().left + 'px';
                    dropIndicator1.style.right = '';
                } else {


                }

                dropIndicator1.style.width = columnWidth + 'px';



                console.log('row');
                dropIndicator1.style.width = ''; // Reset the width if not hovering over a column
            }

            // Position the drop indicator above or below the target row
            var rect = targetRow.getBoundingClientRect();
            var y = event.clientY - rect.top;
            if (y > rect.height / 2) {
                dropIndicator1.style.top = rect.bottom - dropzone.getBoundingClientRect().top + 'px';
            } else {
                dropIndicator1.style.top = rect.top - dropzone.getBoundingClientRect().top - 4 + 'px';
            }

            dropIndicator1.style.display = 'block';
        } else {
            dropIndicator1.style.display = 'none';
        }
    }
}



var dragis = "";
function drag(event,what) {
    event.dataTransfer.setData("text/plain", event.target.outerHTML);
    dragis = what;


}


function randomIntFromInterval(min, max) { // min and max included 
    return Math.floor(Math.random() * (max - min + 1) + min)
}
const rndInt = randomIntFromInterval(2000,9999999999);
var unique_id  = 1001+rndInt;
let currentDragTarget = null;
let dropIndicatorLeft = document.querySelector('.drop-indicator-left');
let dropIndicatorRight = document.querySelector('.drop-indicator-right');
function drop(event) {
    event.preventDefault();
    var rowHTML = event.dataTransfer.getData("text/plain");
    var targetRow = event.target.closest('.row');
    var dropzone = event.target.closest('.dropzone');
    var targetColumn = event.target.closest('.col-lg-6, .col-lg-4, .col-lg-3, .col-lg-8');
    var clientY = event.clientY; // Get the clientY value here
    if (dropzone) {
        if (targetRow || targetColumn) {


            // Remove existing placeholder row and drop indications from other rows
            document.querySelectorAll('.row.placeholder, .row.drop-above, .row.drop-below').forEach((row) => {
                row.remove();
            });

            // If a row is the target, insert the placeholder row above or below the target row based on the drop position


            if (targetColumn && targetColumn.childElementCount === 0) {
                var dropIndicator = document.createElement('div');
                dropIndicator.className = 'drop-indicator';

                // Insert the drop indicator into the column
                targetColumn.appendChild(dropIndicator);

                // Schedule the actual drop after a short delay to prevent flickering
                set_time_out_is(dropIndicator, targetColumn, dropIndicator1,clientY);


            } else {
                var rect = targetRow.getBoundingClientRect();
                var y = event.clientY - rect.top;
                var dropIndicator = document.createElement('div');
                dropIndicator.className = 'drop-indicator';
                if (y > rect.height / 2) {
                    targetRow.insertAdjacentElement('afterend', dropIndicator);
                    targetRow.classList.add('drop-below');
                } else {
                    targetRow.insertAdjacentElement('beforebegin', dropIndicator);
                    targetRow.classList.add('drop-above');
                }

                // Schedule the actual drop after a short delay to prevent flickering
                set_time_out_is(dropIndicator,targetRow,dropIndicator1,clientY);
            }


        } else {
            // If no specific row is targeted, add the new row to the end of the drop zone
            dropzone.insertAdjacentHTML('beforeend', rowHTML);
            console.log('else is calling');
        }


    }




}

function dragLeave(event) {
    var dropzone = event.target.closest('.dropzone');
    if (dropzone) {
        var targetRow = event.target.closest('.row');
        var targetColumn = event.target.closest('.col-lg-6, .col-lg-4, .col-lg-3, .col-lg-8'); // Add this line for columns
        if (!targetRow && !targetColumn) {
            dropzone.querySelector('.drop-indicator').style.display = 'none';
        }
    }
}

function deleteRow(deleteButton) {
    const row = deleteButton.parentElement;
    row.remove();
}

function set_time_out_is(dropIndicator,targetRow,dropIndicator1,clientY) {
    setTimeout(function () {

        unique_id = unique_id + 1;
        if(dragis =="text"){

            dropIndicator.outerHTML = 
                '<div class="row margen_non  draggable" draggable="true" ><div class="delete-button" onclick="deleteRow(this)">Delete</div> <div id="p_funnel_' + unique_id + '" contenteditable="true"  class="text_open col-lg-12 col-xlg-12 col-md-4 "style="text-align: center;font-size: 14px;" ><p  class="" >📍 [Berufsbezeichnung] in [Stadt] gesucht</p></div></div>';



        }else if(dragis == "text_small"){
            dropIndicator.outerHTML = 
                '<div class="row margen_non  draggable" draggable="true" ><div class="delete-button" onclick="deleteRow(this)">Delete</div> <div id="p_funnel_' + unique_id + '" contenteditable="true"  class="text_open col-lg-12 col-xlg-12 col-md-4   "style="text-align: center;font-size: 10px;" ><p  class="" >Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Cras ultricies ligula sed magna dictum porta.</p></div></div>';
        }

        else if(dragis == "text_header"){
            dropIndicator.outerHTML = 
                '<div class="row margen_non  draggable" draggable="true" ><div class="delete-button" onclick="deleteRow(this)">Delete</div> <div id="p_funnel_' + unique_id + '" contenteditable="true"  class="text_open col-lg-12 col-xlg-12 col-md-4   " style="text-align: center;font-size: 40px;font-weight: bold"><p  class="" >Kunden mit Holzkunst begeistern.</p></div></div>';
        }else if(dragis == "icons"){
            dropIndicator.outerHTML = 
                ' <div class="row margen_non  draggable" draggable="true"><div class="delete-button" onclick="deleteRow(this)">Delete</div><div id="icon_' + unique_id + '" class="icon_open col-lg-12 col-xlg-12 col-md-4  "  style="text-align: center;font-size: 45px;"><i class=" fas fa-laugh"></i></div></div>';
        }
        else if(dragis == "button"){
            dropIndicator.outerHTML = 
                ` <div class="row margen_non  draggable" draggable="true"><div class="delete-button" onclick="deleteRow(this)">Delete</div><div id="btn_` + unique_id + `" class="open_button col-lg-12 col-xlg-12 col-md-12  " style="text-align: center;" ><a  onclick="showAnswer_20('1')" href="#" contenteditable="true" class="btn btn-info btn-rounded waves-effect waves-light ">i want to learn more </a> </div></div>`;
        }
        else if(dragis == "image"){
            dropIndicator.outerHTML = 
                '   <div class="row margen_non  draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div id="image_' + unique_id + '" class=" open_image col-lg-12 col-xlg-12 col-md-12  " style="text-align: center;" ><img  src="https://qualityfriend.solutions/assets/images/image-placeholder.png"  alt="" class="dark-logo logo_padding fit_to_div" /> </div></div>';
        }
        else if(dragis == "audio"){
            dropIndicator.outerHTML = 
                '<div class="row margen_non  draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div id="audio_' + unique_id + '"  class="audio_open col-lg-12 col-xlg-12 col-md-4 text_size_big" style="text-align: center;" ><img  src="https://qualityfriend.solutions/assets/images/full_time.jpg"  alt="" class="border_is img-circle  logo_height_and_width" /><br><audio controls controls class="audio-tag" type="audio/mp3" src="https://qualityfriend.solutions/images/testing.mp3">Your browser does not support the audio element.</audio></div></div>';


        }

        else if(dragis == "spacers"){
            dropIndicator.outerHTML = 
                '<div class="row margen_non  draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div id="spacrs_' + unique_id + '"  class="spacers_open col-lg-12 col-xlg-12 col-md-4 text_size_big pt-4 pb-4" style="text-align: center;" ><div style="height: 1px; width: 100%; background: rgb(204, 204, 204);" ></div></div></div>';
        }

        else if(dragis == "video"){
            dropIndicator.outerHTML = 
                '<div class="row margen_non  draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div id="video_' + unique_id + '"  class="video_open col-lg-12 col-xlg-12 col-md-4 text_size_big" style="text-align: center;" > <iframe src="https://player.vimeo.com/video/732025226" width="85%"    height="400" frameborder="0" allowfullscreen ></iframe></div></div>';
        }
        else if(dragis == "single"){
            dropIndicator.outerHTML = 
                `<div class="row margen_non   draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div class=" col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_non" draggable="true"  ><div class="custom_container row   draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div onclick="showAnswer_20('1')" id=single_"`+ unique_id +` " class="single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  "><div class="d-flex align-items-center"><div class="mr-2"><i class="fas fa-2x fa-angle-right"></i> <!-- Small Icon --></div><div contenteditable="true"  class="flex-grow-1" style="text-align: left" ><p class="m-0">Yes, I have</p> </div><div  class="ml-2 single_selection_icon"><i class="fas  fa-thumbs-up"></i> </div></div></div></div></div>        <div class=" col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_non" draggable="true"  ><div class="custom_container row   draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div onclick="showAnswer_20('1')" id="single_`+ unique_id +`${Math.random()}" class="single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  "><div class="d-flex align-items-center"><div class="mr-2"><i class="fas fa-2x fa-angle-right"></i> </div><div contenteditable="true"  class="flex-grow-1" style="text-align: left" ><p class="m-0">No I havent</p></div><div  class="ml-2 single_selection_icon"><i class="fas  fa-thumbs-down "></i> </div>    </div></div></div></div><div id="single_plus_id_`+ unique_id +`" class="single_plus col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_non" draggable="true"  ><div class=" row "><div id="single_plus_ `+ unique_id +`${Math.random()}" class="   margen_non   col-lg-12 col-xlg-12 col-md-12  "><div class="custom-column_add "><i class="fas fa-2x fa-plus"></i></div></div></div></div></div>`;
        }
        else if(dragis == "multi"){
            dropIndicator.outerHTML = 
                ` <div class="row margen_non   draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div class=" col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_non" draggable="true"  ><div class="custom_container row   draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div>
<div id="multi_selection_`+ unique_id +`" class="multi_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  "><div class="d-flex align-items-center">
<div class="mr-2"><input class="" type="checkbox" value="" id=""> 
</div><div contenteditable="true"  class="flex-grow-1" style="text-align: left" >
<p class="m-0">Safe & stable workplace</p> 
</div><div  class="ml-2 single_selection_icon">
<i class="fas  fa-shield-alt"></i> </div></div></div></div></div>
<div class=" col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_non" draggable="true"  >
<div class="custom_container row   draggable" draggable="true"  >
<div class="delete-button" onclick="deleteRow(this)">Delete</div>
<div id="multiple_selection_`+ unique_id +`${Math.random()}"  class="multi_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  "><div class="d-flex align-items-center"><div class="mr-2 pl-2"><input class="" type="checkbox" value="" id=""> </div><div contenteditable="true"  class="flex-grow-1" style="text-align: left" >
<p class="m-0">Safe & stable workplace</p> </div><div  class="ml-2 single_selection_icon"><i class="fas  fa-clock "></i> </div></div></div></div></div><div class=" col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_non" draggable="true"  ><div class="custom_container row   draggable" draggable="true"  >
<div class="delete-button" onclick="deleteRow(this)">Delete</div>
<div id="multiple_selection1_`+ unique_id +`${Math.random()}" class="multi_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  "><div class="d-flex align-items-center">
<div class="mr-2 pl-2"><input class="" type="checkbox" value="" id=""> </div><div contenteditable="true"  class="flex-grow-1" style="text-align: left" ><p class="m-0">continuing education</p></div>
<div  class="ml-2 single_selection_icon">
<i class="fas  fa-clock "></i> </div></div></div></div></div>
<div class=" col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_non" draggable="true"  >
<div class="custom_container row   draggable" draggable="true"  >
<div class="delete-button" onclick="deleteRow(this)">Delete</div>
<div id="multiple_selection23_`+ unique_id +`${Math.random()}" class="multi_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  ">
<div class="d-flex align-items-center">
<div class="mr-2 pl-2"><input class="" type="checkbox" value="" id=""> </div><div contenteditable="true"  class="flex-grow-1" style="text-align: left" >
<p class="m-0">Creative unfolding</p></div><div  class="ml-2 single_selection_icon"><i class="fas  fa-broom "></i> </div></div></div></div></div><div id="multi_id_3" class="multi_plus col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_non" draggable="true"  ><div class=" row "><div id="multiple_selectionww1_`+ unique_id +`${Math.random()}" class="   margen_non   col-lg-12 col-xlg-12 col-md-12  "><div class="custom-column_add "><i class="fas fa-2x fa-plus"></i></div></div></div></div></div>`;
        }
        else if(dragis == "area"){
            dropIndicator.outerHTML = 
                ` <div class="row margen_non  draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div id="p_funnel_6.881`+ unique_id +`" contenteditable="true"  class="textarea_open col-lg-12 col-xlg-12 col-md-4 " style="text-align: center;font-size: 14px;" ><textarea style="min-width: 200px; max-width: 600px;" class="form-control" placeholder="What are you currently doing?  Where are your skills and strengths?" id="" name="" rows="6" cols="100"></textarea></div></div>`;
        }
        else if(dragis == "three"){
            dropIndicator.outerHTML = 
                ` <div class="row margen_non  draggable" draggable="true"  >
<div class="delete-button" onclick="deleteRow(this)">Delete</div><div  class="col-lg-12 col-xlg-12 col-md-4 text-center"><div class="row margen_non  draggable" draggable="true"  ><div class="col-lg-4 col-xlg-4 col-md-4 text-center " draggable="true" ></div><div class="col-lg-4 col-xlg-4 col-md-4 text-center " draggable="true"  ></div><div class="col-lg-4 col-xlg-4 col-md-4 text-center " draggable="true"  ></div></div></div></div>`;
        }

        else if(dragis == "two"){
            dropIndicator.outerHTML = 
                ` <div class="row margen_non  draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div id="p_funnel_6.881`+ unique_id +`" contenteditable="true"  class="textarea_open col-lg-12 col-xlg-12 col-md-4 " style="text-align: center;font-size: 14px;" ><textarea style="min-width: 200px; max-width: 600px;" class="form-control" placeholder="What are you currently doing?  Where are your skills and strengths?" id="" name="" rows="6" cols="100"></textarea></div></div>`;
        }
        else if(dragis == "four"){
            dropIndicator.outerHTML = 
                ` <div class="row margen_non  draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div id="p_funnel_6.881`+ unique_id +`" contenteditable="true"  class="textarea_open col-lg-12 col-xlg-12 col-md-4 " style="text-align: center;font-size: 14px;" ><textarea style="min-width: 200px; max-width: 600px;" class="form-control" placeholder="What are you currently doing?  Where are your skills and strengths?" id="" name="" rows="6" cols="100"></textarea></div></div>`;
        }else if(dragis == "one_by_two"){
            dropIndicator.outerHTML = 
                ` <div class="row margen_non  draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div id="p_funnel_6.881`+ unique_id +`" contenteditable="true"  class="textarea_open col-lg-12 col-xlg-12 col-md-4 " style="text-align: center;font-size: 14px;" ><textarea style="min-width: 200px; max-width: 600px;" class="form-control" placeholder="What are you currently doing?  Where are your skills and strengths?" id="" name="" rows="6" cols="100"></textarea></div></div>`;
        }
        else if(dragis == "form"){
            dropIndicator.outerHTML = 
                `  <div class="row margen_non  draggable" draggable="true"  ><div class="delete-button" onclick="deleteRow(this)">Delete</div><div id="form_no1_`+ unique_id +`" contenteditable="true"  class="form_open col-lg-12 col-xlg-12 col-md-4 " style="text-align: center;" ><div class="input-group mb-3 pl-4 pr-4"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div><input type="text" class="form-control" placeholder="Username"></div><div class="input-group mb-3 pl-4 pr-4"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div><input type="email" class="form-control" placeholder="Email"></div><div class="input-group mb-3 pl-4 pr-4"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-flag"></i></span></div><input type="number" class="form-control" placeholder="Phone Number"></div>
<div class="checkbox checkbox-success pl-4 pr-4"><div class="error-checkbox">
<input  required id="submit_require_no `+ unique_id +`" type="checkbox"><label class="d-inline" for="submit_required2111"> I agree to the<a class="color_is"  onclick="event_privacy()" href="JavaScript:void(0);" ><u>
privacy policy </u></a> of First Name Last Name and allow me to contact you.</label>
</div></div><a onclick="showAnswer_20('thanks')" href="#" contenteditable="true" class="btn btn-info btn-rounded waves-effect waves-light mt-4">I want to get to know you </a></div></div>`;
        }
        else if(dragis == "file"){
            dropIndicator.outerHTML = 
                ` <div class="row margen_non  draggable" draggable="true"  >
<div class="delete-button" onclick="deleteRow(this)">Delete</div>
<div id="p_funnel_upload_7h0000`+ unique_id +`" contenteditable="true"  class="cv_open col-lg-12 col-xlg-12 col-md-4 " style="text-align: center;font-size: 24px;" >
<div class="custom-file-container">
<div class="solid-border">
<div class="dotted-border" id="dottedContainerid `+ unique_id +`">
<input type="file" id="cv_id1_`+ unique_id +`" style="display: none;">
<div class="upload-icon">
<i class="fas fa-cloud-upload-alt"></i>
</div>
<div class="upload-text" id="uploadText12`+ unique_id +`">
Click or drop a file here
</div>
<div class="remove-file-link" id="removeFileLink`+ unique_id +`" style="display: none;">Remove</div>
</div>
</div>
</div>
<a onclick="showAnswer_20('9')" href="#" contenteditable="true" class="btn btn-info btn-rounded waves-effect waves-light mt-4">Send</a>
<br>
<p onclick = "showAnswer_20('9','skip')" class="mt-4 skip_p"  >Skip</p>
<div class="message mt-3">Please select a file.</div>
</div>
</div>`;
        }





        dropIndicator.remove();
        targetRow.classList.remove('drop-above', 'drop-below');





        dropIndicator1.style.removeProperty("display");

        // Hide the drop indicator after drop
        dropIndicator1.style.display = 'none';

        text_open_run();
        icon_open_run();
        button_open_run();
        image_open_run();
        audio_open_run();
        video_open_run();
        single_selection_open_run();
        add_single_selection();
        add_multi_selection();
        multi_selection_open_run();
        form_open_run();
        cv_open_run();


    }, 100);
}

