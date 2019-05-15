(function () {
	var streaming = false
		var width = 640;
	var height = 450;
	navigator.getUserMedia = ( navigator.getUserMedia ||
			navigator.webkitGetUserMedia ||
			navigator.mozGetUserMedia);

	var take= document.getElementById("take");
	take.addEventListener('click', takeSnap);


//	u.addEventListener('push', upSnap);


//	var upl= document.getElementById("upload");
//	upl.addEventListener('up', upSnap);

	// var supr= document.getElementById("pic");
	// take.addEventListener('click', confirm("lol"));

	upload
	var constraints = {
		video: true,
		audio: false
	};

	if (navigator.getUserMedia) {
		navigator.getUserMedia({ audio: false, video: { width: 640, height: 450 } },
				function(stream) {
					var video = document.querySelector('video');
					video.srcObject = stream;
					video.onloadedmetadata = function(e) {
						video.play();
					};
				},
				function(err) {
			document.getElementById("take").hidden = true;
					console.log("The following error occurred: " + err.name);
				}
				);
	} else {
		console.log("getUserMedia not supported");
	}

	video.addEventListener('canplay', function(ev){
		if (!streaming) {
			video.setAttribute('width', width);
			video.setAttribute('height', height);
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			streaming = true;
		}
	}, false);

	img=document.getElementById("img");
	input= document.getElementById("upload");
	upl= document.getElementById("upl");
	input.onchange = function(event)
	{

		video.style.display = "none";
		canvas.style.display = "block";
		canvas.width = 640;
		canvas.height = 450;

		if (this.files[0])
		{
			img.src = window.URL.createObjectURL(this.files[0]);
			document.getElementById("take").hidden = true;
			document.getElementById("id_tof").hidden = false;
		}
		img.addEventListener("load", cargado);

		function cargado(e)
		{
			canvas.getContext('2d').drawImage(img, 0, 0, canvas.width, canvas.height);
			data = canvas.toDataURL('image/png');
			//		if (videoplay)
			//			{
			//				let stream = video.src;
			//				let tracks = stream.getTracks();
			//
			//				tracks.forEach(function(track) {
			//					track.stop();
			//				});
			//				video.srcObject = null;
			//			}
			videoplay = false;
			var image= document.getElementById("image");
			image.value = data;
			return (data);
		}
	}
})();




function errorCallback(err) {
	console.log("The following error occured: " + err);
};
/*
function upSnap()
{
	var canvas = document.querySelector('canvas'),
	canvas.width = 640;
	canvas.height = 450;
	var data = canvas.toDataURL("./uploads/"+ la photo);
	var image=document.getElementById("upl");
	image.value = data;
	alert(image.value);
	canvas.setAttribute('src', image.value);
	return (data);
}
*/
function takeSnap() {
	var canvas = document.querySelector('canvas'),
	video = document.querySelector('video');

			document.getElementById("id_tof").hidden = false;
	canvas.width = 640;
	canvas.height = 450;
	canvas.getContext('2d').drawImage(video, 0, 0, 640, 450);
	var data = canvas.toDataURL();
	var image= document.getElementById("image");
	image.value = data;
//	console.log(image.value);
//	alert(image.value);
	canvas.setAttribute('src', image.value);
	return (data);
};


