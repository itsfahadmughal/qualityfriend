//$(document).ready(function() {
//
//    const emojiButton = document.querySelector('#emoji-picker');
//    let pickerVisible = false;
//
//
//    emojiButton.addEventListener('click', function() {
//        if (!pickerVisible) {
//            pickerVisible = true;
//            showPickerAtButton();
//        } else {
//            pickerVisible = false;
//            hidePicker();
//        }
//    });
//
//
//
//    function showPickerAtButton() {
//        const editableH1 = document.getElementById(selected_text_id);
//        const cursorPosition = window.getSelection().focusOffset;
//        const beforeCursor = editableH1.textContent.slice(0, cursorPosition);
//        const afterCursor = editableH1.textContent.slice(cursorPosition);
//        const pickerOptions = {
//            onEmojiSelect: function(emoji) {
//
//
//
//
//                console.log(beforeCursor);
//
//
//                editableH1.textContent = beforeCursor + emoji.native + afterCursor;
//            },
//        };
//        picker = new EmojiMart.Picker(pickerOptions);
//
//        const rect = emojiButton.getBoundingClientRect();
//        const top = window.scrollY + rect.bottom;
//        const left = window.scrollX + rect.left;
//        picker.style.position = 'absolute';
//        picker.style.top = top + 'px';
//        picker.style.left = left + 'px';
//        document.body.appendChild(picker);
//
//
//    }
//
//    function hidePicker() {
//        if (picker && picker.parentNode) {
//            picker.parentNode.removeChild(picker);
//        }
//    }
//
//});

















$(document).ready(function() {

    const emojiButton = document.querySelector('#emoji-picker');
    let pickerVisible = false;
    let picker;

    emojiButton.addEventListener('click', function() {
        if (!pickerVisible) {




            pickerVisible = true;
            showPickerAtButton();
        } else {
            hidePicker();
            pickerVisible = false;
        }
    });

    function showPickerAtButton() {

        const pickerOptions = {
            onEmojiSelect: function(emoji) {

                const editableH1 = document.getElementById(selected_text_id);
                const cursorPosition = window.getSelection().focusOffset;
                console.log(cursorPosition);
                const beforeCursor = editableH1.textContent.slice(0, cursorPosition);
                console.log(beforeCursor);
                const afterCursor = editableH1.textContent.slice(cursorPosition);
                editableH1.textContent = beforeCursor + emoji.native + afterCursor;
            },
        };
        picker = new EmojiMart.Picker(pickerOptions);

        const rect = emojiButton.getBoundingClientRect();
        const top = window.scrollY + rect.bottom;
        const left = window.scrollX + rect.left;
        picker.style.position = 'absolute';
        picker.style.top = top + 'px';
        picker.style.left = left + 'px';
        document.body.appendChild(picker);


    }

    function hidePicker() {
        if (picker && picker.parentNode) {


            document.body.removeChild(picker);
        }
    }
});

//for single selection


$(document).ready(function() {

    const emoji_picker_s = document.querySelector('#emoji-picker_s');
    let pickerVisible_s = false;
    let picker_s;

    emoji_picker_s.addEventListener('click', function() {
        if (!pickerVisible_s) {




            pickerVisible_s = true;
            showPickerAtButton_s();
        } else {
            hidePicker_s();
            pickerVisible_s = false;
        }
    });

    function showPickerAtButton_s() {

        const pickerOptions_s = {
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
        picker_s = new EmojiMart.Picker(pickerOptions_s);

        const rect = emoji_picker_s.getBoundingClientRect();
        const top = window.scrollY + rect.bottom;
        const left = window.scrollX + rect.left;
        picker_s.style.position = 'absolute';
        picker_s.style.top = top + 'px';
        picker_s.style.left = left + 'px';
        document.body.appendChild(picker_s);


    }

    function hidePicker_s() {
        if (picker_s && picker_s.parentNode) {


            document.body.removeChild(picker_s);
        }
    }
});


