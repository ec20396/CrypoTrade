function changeVideo(source) {
    var video = document.getElementById("bg-video");
    var sourceElement = document.getElementById("video-source");
    sourceElement.src = source;
    video.load();
  }
  //this is the js for swapping background vid