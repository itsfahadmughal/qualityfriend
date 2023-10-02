const currentURL = window.location.href;
var current_lang = 'funnel_php/upload.php';
var current_lang_a = 'funnel_php/upload_audio.php';
var mylan = '';

// Check if the URL contains 'it/'
if (currentURL.includes('/it/')) {
    current_lang = '../funnel_php/upload.php';

    current_lang_a = '../funnel_php/upload_audio.php';

    mylan = '../';
}
// Check if the URL contains 'de/'
else if (currentURL.includes('/de/')) {
    current_lang = '../funnel_php/upload.php';

    current_lang_a = '../funnel_php/upload_audio.php';

    mylan = '../';
}
// If neither 'it/' nor 'de/' is found, assume English
else {
    current_lang = 'funnel_php/upload.php';

    current_lang_a = 'funnel_php/upload_audio.php';
    mylan = '';
}










var imageInput = document.getElementById('imageInput');
imageInput.addEventListener('change', function() {
    var  myDiv   = document.getElementById(selected_text_id);
    const imageDiv = myDiv.getElementsByTagName('img');
    for (let i = 0; i < imageDiv.length; i++) {
    }
    var selectedImage = imageInput.files[0];
    if (selectedImage) {


        var imageURL = URL.createObjectURL(selectedImage);
        //        imageDiv[0].src = imageURL;



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
$('.dropify').on('dropify.afterClear', function(event, element) {
    // This function will be triggered when the Dropify "Remove" button is clicked
    var  myDiv   = document.getElementById(selected_text_id);
    const imageDiv = myDiv.getElementsByTagName('img');
    //    imageDiv[0].src = "http://localhost/qualityfriend/assets/images/image-placeholder.png";


    imageDiv[0].src = "https://qualityfriend.solutions/assets/images/image-placeholder.png";
});
var open_image = document.getElementsByClassName("open_image");
//button change color
var show_tools_image = function() {
    var attribute = this.getAttribute("data-myattribute");
    var id_is = this.id;

    open_ideal();
    selected_text_id = id_is;
    just_hide_leftpage();
    alltools('for_only_image');
    const divElement = document.getElementById(selected_text_id);
    const aElement = divElement.querySelector('img');
    const aComputedStyle = window.getComputedStyle(aElement);
    const imgSrc = aElement.getAttribute('src');
    var imageInput = document.getElementById('imageInput');
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
                var drEvent = $('#imageInput').dropify(
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

        var drEvent = $('#imageInput').dropify(
            {
                defaultFile: imagenUrl
            });
        drEvent = drEvent.data('dropify');
        drEvent.resetPreview();
        drEvent.settings.defaultFile = imagenUrl;
        drEvent.destroy();
        drEvent.init();
    }





}



image_open_run();
function image_open_run() {
    for (var i = 0; i < open_image.length; i++) {
        open_image[i].addEventListener('click', show_tools_image, false);


    }
}