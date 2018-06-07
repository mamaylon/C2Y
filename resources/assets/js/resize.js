window.resize = (function () {

	'use strict';

	function Resize() {
		//
	}

	Resize.prototype = {

		init: function(outputQuality) {
			this.outputQuality = (outputQuality === 'undefined' ? 0.8 : outputQuality);
		},
		resize: function(dataURL, outputType, callback, mark="") {

			var _this = this;

			var image = new Image();
			image.onload = function (imageEvent) {

				// Resize image
				var canvas = document.createElement('canvas'),
					width = image.width,
					height = image.height,
					widthD = 800,
					heightD = 600,
					offsetW = 0,
					offsetH = 0;

				var ratio_orig = width/height;

				if (widthD/heightD > ratio_orig) 
				{
					widthD = heightD*ratio_orig;
				} 
				else 
				{
					heightD = widthD/ratio_orig;
				}

				if(widthD < 800)
				{
					offsetW = 400-(widthD/2)
				}
				if(heightD < 600)
				{
					offsetH = 300-(heightD/2)
				}
				
				canvas.width = 800;
				canvas.height = 600;
				canvas.getContext('2d').drawImage(image, offsetW, offsetH, widthD, heightD);
				if(mark != "")
				{
					var vMark = new Image();
					vMark.src = mark;
					canvas.getContext('2d').drawImage(vMark, (widthD+offsetW-130), (heightD+offsetH-70),130,70);
				}

				_this.output(canvas, outputType, callback);

			}
			image.src = dataURL;

		},

		output: function(canvas, outputType, callback) {

			switch (outputType) {

				case 'file':
					canvas.toBlob(function (blob) {
						callback(blob);
					}, 'image/jpeg', 0.8);
					break;

				case 'dataURL':
					callback(canvas.toDataURL('image/jpeg', 0.8));
					break;

			}

		}

	};

	return Resize;

}());
