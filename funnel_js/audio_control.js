//For Audio

const audioUpload = document.getElementById('audio-upload');
const audioPlayer = document.querySelector('.audio-player');
const audioElement = document.getElementById('audio-element');
const uploadLabel = document.getElementById('upload-label');
const deleteIcon = audioPlayer.querySelector('.delete-icon');
const playIcons = document.querySelectorAll('.audio_open');


var audio_imageInput = document.getElementById('audio_imageInput');
audio_imageInput.addEventListener('change', function() {
    var  myDiv   = document.getElementById(selected_text_id);
    const imageDiv = myDiv.getElementsByTagName('img');
    for (let i = 0; i < imageDiv.length; i++) {
    }
    var selectedImage = audio_imageInput.files[0];
    if (selectedImage) {
        var imageURL = URL.createObjectURL(selectedImage);
        // Fetch the Blob content
        fetch(imageURL)
            .then(response => response.blob())
            .then(blob => {
            var formData = new FormData();
            formData.append('image', blob, 'image.png'); // 'image' is the field name

            // Send Blob data to the server
            fetch(current_lang, {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(serverImageUrl => {
                //                var new_url = "http://localhost/qualityfriend/funnel_php/"+serverImageUrl;


                var new_url = "https://qualityfriend.solutions/funnel_php/"+serverImageUrl;




                imageDiv[0].src = new_url;

                console.log(new_url);
            });
        });
    }else{
        console.log("no image");
    }
});
// Add event listener for the dropify-beforeClear event

var audio_open = document.getElementsByClassName("audio_open");
var current_url = "";
var current_url_index = 0;
var show_tools_audio = function() {
    var attribute = this.getAttribute("data-myattribute");
    var id_is = this.id;
    open_ideal();
    selected_text_id = id_is;
    just_hide_leftpage();
    alltools('for_only_audio');
    const divElement = document.getElementById(selected_text_id);
    const aElement = divElement.querySelector('img');
    const aComputedStyle = window.getComputedStyle(aElement);
    const imgSrc = aElement.getAttribute('src');
    var imageInput = document.getElementById('audio_imageInput');
    var imagenUrl = imgSrc;
    //for alogment 
    const textAlign = aComputedStyle.getPropertyValue("text-align");
    console.log(textAlign);
    get_alignment(textAlign)
    if (imgSrc.startsWith('blob:http')) {

        // Fetch the Blob content
        fetch(imgSrc)
            .then(response => response.blob())
            .then(blob => {
            var formData = new FormData();
            formData.append('image', blob, 'image.png'); // 'image' is the field name

            // Send Blob data to the server
            fetch(current_lang, {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(serverImageUrl => {

                //                var new_url = "http://localhost/qualityfriend/funnel_php/"+serverImageUrl;

                var new_url = "https://qualityfriend.solutions/funnel_php/"+serverImageUrl;

                console.log(new_url)
                var drEvent = $('#audio_imageInput').dropify(
                    {
                        defaultFile: new_url
                    });
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.settings.defaultFile = new_url;
                drEvent.destroy();
                drEvent.init();
            });
        });

    }else {

        var drEvent = $('#audio_imageInput').dropify(
            {
                defaultFile: imagenUrl
            });
        drEvent = drEvent.data('dropify');
        drEvent.resetPreview();
        drEvent.settings.defaultFile = imagenUrl;
        drEvent.destroy();
        drEvent.init();
    }

    //audio\
    const audioTag = divElement.querySelector('audio');



    if (audioTag) {
        const src = audioTag.src;
        if (src) {
            if (src.trim() === '') {
                console.log('Audio src is empty');
            } else {
                audioElement.src = src;
                audioPlayer.style.display = 'flex';
                uploadLabel.style.display = 'none';
                deleteIcon.style.display = 'inline';
            }
        } else {
            console.log('Audio src does not exist');
        }
    } else {
        console.log('Audio tag not found');
    }



}



audio_open_run();
function audio_open_run() {
    for (var i = 0; i < audio_open.length; i++) {
        audio_open[i].addEventListener('click', show_tools_audio, false);
    }
}


//handle upload audio
audioUpload.addEventListener('change', () => {
    const file = audioUpload.files[0];
    const formData = new FormData();
    formData.append('audio', file);

    fetch(current_lang_a, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
        const filePath = data.filePath;
        audioElement.src = mylan+filePath;
        audioPlayer.style.display = 'flex';
        uploadLabel.style.display = 'none';
        deleteIcon.style.display = 'inline';

        //add from page
        const divElement = document.getElementById(selected_text_id);
        const audioTag = divElement.querySelector('audio');
        audioTag.src = mylan+filePath;
        audioTag.load();



    })
        .catch(error => {
        console.error('Error uploading audio:', error);
    });
});

deleteIcon.addEventListener('click', () => {
    audioElement.src = '';
    audioPlayer.style.display = 'none';
    uploadLabel.style.display = 'block';
    deleteIcon.style.display = 'none';
    audioUpload.value = ''; // Reset file input


    //remove from page
    const divElement = document.getElementById(selected_text_id);
    const audioTag = divElement.querySelector('audio');
    audioTag.src = "";
    audioTag.load();
});





