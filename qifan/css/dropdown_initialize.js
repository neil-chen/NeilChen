		var preloaded = [];

		for (var i = 1; i <= 8; i++) {
			preloaded[i] = [loadImage(i + "-1.gif"), loadImage(i + "-1.gif")];		//设置图片的OnMouseOver和OnMouseOut的路径
		}

		function init() {

			if (mtDropDown.isSupported()) {
				mtDropDown.initialize();

			}
		}

		function loadImage(sFilename) {
			var img = new Image();
			img.src ="" + sFilename;
			return img;
		}

		function swapImage(imgName, sFilename) {
			document.images[imgName].src = sFilename;
		}