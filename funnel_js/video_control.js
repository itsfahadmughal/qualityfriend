//


const videoUrlInput = document.getElementById('videoUrl');
videoUrlInput.addEventListener('input', () => {

    const videoCol = document.getElementById(selected_text_id);
    const videoUrl = videoUrlInput.value;
    const videoId = extractVideoIdFromUrl(videoUrl);

    if (videoId) {
        // Clear previous video
        videoCol.innerHTML = '';

        // Check if YouTube or Vimeo URL
        if (videoUrl.includes('youtube.com')) {
            const iframe = document.createElement('iframe');
            iframe.setAttribute('src', `https://www.youtube.com/embed/${videoId}`);
            iframe.setAttribute('width', '100%');
            iframe.setAttribute('height', '400');
            iframe.setAttribute('allowfullscreen', '');

            videoCol.appendChild(iframe);
        } else if (videoUrl.includes('vimeo.com')) {
            const iframe = document.createElement('iframe');
            iframe.setAttribute('src', `https://player.vimeo.com/video/${videoId}`);
            iframe.setAttribute('width', '100%');
            iframe.setAttribute('height', '400');
            iframe.setAttribute('allowfullscreen', '');

            videoCol.appendChild(iframe);
        }
    }
});

//get open 

var video_open = document.getElementsByClassName("video_open");

var show_tools_video = function(event) {
    var attribute = this.getAttribute("data-myattribute");
    var id_is = this.id;

    open_ideal();
    selected_text_id = id_is;
    just_hide_leftpage();
    alltools('for_only_video');

    const videoCol = document.getElementById(selected_text_id);
    const iframe = videoCol.querySelector('iframe');
    const iframeSrc = iframe.getAttribute('src');
    let final = convertIframeSrcToURL(iframeSrc);
    videoUrlInput.value = final;

    event.stopPropagation();
};

video_open_run();

function video_open_run() {
    for (var i = 0; i < video_open.length; i++) {
        video_open[i].addEventListener('click', show_tools_video, false);
    }
}

// Add a mousedown event listener to the document to capture clicks
document.addEventListener('mousedown', function(event) {
    for (var i = 0; i < video_open.length; i++) {
        // Check if the clicked element or its ancestor is a video_open element
        if (event.target === video_open[i] || video_open[i].contains(event.target)) {
            show_tools_video.call(video_open[i]);
            break; // Stop checking if the element was found
        }
    }
});

function convertIframeSrcToURL(src) {
    const youtubeRegex = /youtube\.com\/embed\/([^?]+)/;
    const vimeoRegex = /player\.vimeo\.com\/video\/([^?]+)/;

    const youtubeMatch = src.match(youtubeRegex);
    const vimeoMatch = src.match(vimeoRegex);

    if (youtubeMatch) {
        return `https://www.youtube.com/watch?v=${youtubeMatch[1]}`;
    } else if (vimeoMatch) {
        return `https://vimeo.com/${vimeoMatch[1]}`;
    }

    return src;
}



//Extract video ID from YouTube or Vimeo URL
function extractVideoIdFromUrl(url) {
    const youtubeRegex = /[?&]v=([^&]+)/;
    const vimeoRegex = /vimeo\.com\/(\d+)/;
    const youtubeMatch = url.match(youtubeRegex);
    const vimeoMatch = url.match(vimeoRegex);

    if (youtubeMatch) {
        return youtubeMatch[1];
    } else if (vimeoMatch) {
        return vimeoMatch[1];
    }

    return null;
}