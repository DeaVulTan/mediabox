var attachments_formats = Array('doc', 'docx', 'xls', 'xlsx', 'pdf', 'zip', 'txt');

function fileQueueError(file, errorCode, message) {
	try {
		var imageName = "error.gif";
		var errorName = "";
		if (errorCode === SWFUpload.errorCode_QUEUE_LIMIT_EXCEEDED) {
			errorName = "You have attempted to queue too many files.";
		}

		if (errorName !== "") {
			alert_manual(errorName);
			return;
		}

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			imageName = "zerobyte.gif";
			break;
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			alert_manual(file_upload_limit_exceeds);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			alert_manual(message);
			break;
		default:
			alert_manual('You have exceeded the maximum pictures allowed limit ');
			break;
		}

		//addImage("images/" + imageName);

	} catch (ex) {
		this.debug(ex);
	}

}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if (numFilesQueued > 0) {
			this.startUpload();
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadProgress(file, bytesLoaded) {
   try
   		{
		var percent = Math.ceil((bytesLoaded / file.size) * 100);

		var progress = new FileProgress(file,  this.customSettings.upload_target);
		progress.setProgress(percent);
		if (percent === 100) {
			progress.setStatus("Creating thumbnail...");
			progress.toggleCancel(false, this);
		} else {
			progress.setStatus("Uploading...");
			progress.toggleCancel(true, this);
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess(file, sData) {
	try {
		var progress = new FileProgress(file,  this.customSettings.upload_target);
		var serverData = sData;
		var a = new Array();
		a = serverData.split("#");

		if (a[0].substring(0, 7) == "FILEID:") {
			addImage(a[0].substring(7));
			addHiddenElement(a[0].substring(7));
			addHiddenElementForName(a[1], a[0].substring(7));
			progress.setStatus("Thumbnail Created.");
			progress.toggleCancel(false);
		} else {
			addImage("images/error.gif");
			progress.setStatus("Error.");
			progress.toggleCancel(false);

		}


	} catch (ex) {
		this.debug(ex);
	}
}

function uploadComplete(file) {
	try {
		/*  I want the next upload to continue automatically so I'll call startUpload here */
		if (this.getStats().files_queued > 0) {
			this.startUpload();
		} else {
			var progress = new FileProgress(file,  this.customSettings.upload_target);
			progress.setComplete();
			progress.setStatus("All images received.");
			progress.toggleCancel(false);
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadError(file, errorCode, message) {
	var imageName =  "error.gif";
	var progress;
	try {
		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			try {
				progress = new FileProgress(file,  this.customSettings.upload_target);
				progress.setCancelled();
				progress.setStatus("Cancelled");
				progress.toggleCancel(false);
			}
			catch (ex1) {
				this.debug(ex1);
			}
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			try {
				progress = new FileProgress(file,  this.customSettings.upload_target);
				progress.setCancelled();
				progress.setStatus("Stopped");
				progress.toggleCancel(true);
			}
			catch (ex2) {
				this.debug(ex2);
			}
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			imageName = "uploadlimit.gif";
			break;
		default:
			alert(message);
			break;
		}

		addImage("images/" + imageName);

	} catch (ex3) {
		this.debug(ex3);
	}

}


function addImage(src) {
	var newImgDiv = document.createElement("span");
	var a = "discussions/files/uploads/thumbs/";
	var b = a.length;

	var c = src.substring(b);
	var cnt ;
	var  d;
	d = c.substr(0,47);
	newImgDiv.id = d;
	document.getElementById("thumbnails").appendChild(newImgDiv);

	extern = c.split(".");
	var other_format = false;
	for(ai=0; ai<attachments_formats.length; ai++)
	{
		if(attachments_formats[ai] == extern[1]){
			other_format = true;
			//break;
		}
	}

	if(other_format == true)
	{
		tagName = "p";
		var newImg = document.createElement("p");
	}
	else
	{
		var newImg = document.createElement("img");
		newImg.style.margin = "0px 5px 10px 0px";
		newImg.src = SITE_URL+src;
	}

		setTimeout(function test(){document.getElementById(d).appendChild(newImg);if (newImg.filters) {
			try {
				newImg.filters.item("DXImageTransform.Microsoft.Alpha").opacity = 100;
			} catch (e) {
				// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
				newImg.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + 100 + ')';
			}
		} else {
			newImg.style.opacity = 100;
		}

		newImg.onload = function () {
			fadeIn(newImg, 0);
		};



	var remove = document.createElement("span");

	remove.onclick = function() { removeElement('thumbnails', d) };
	remove.innerHTML = "";
	remove.className = 'clsRemoveImg';
	remove.title = LANG_header_remove;

	//alert(extern[0]+' - '+extern[1]);
	if(other_format == true)
	{
		doc_name = c.split("_");
		final_doc_name = doc_name[1]+"."+extern[1];
		var document_name = document.createElement("span");
		document_name.className = "clsDoc";
		document_name.innerHTML = final_doc_name;
		document.getElementById(d).appendChild(document_name);
	}

	document.getElementById(d).appendChild(remove);
	chkImgCount();},100);

}
function chkImgCount()
	{
		var thumbnails = document.getElementById("thumbnails");
		items = thumbnails.getElementsByTagName("img");
		var w =0;
		var uploaded_images = document.getElementById("uploaded_images");

		if(uploaded_images !=null)
			{
				items_uploaded = uploaded_images.getElementsByTagName("img");
				w = items_uploaded.length ;
			}

			var c = items.length + w ;

//alert(SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT);

			if(c >= file_upload_limit)
				{
					document.getElementById("image_uploads").style.display = "none";
//					SWFUpload.prototype.stopUpload();
					//progress = new FileProgress(file,  this.customSettings.upload_target);
					//progress.setCancelled();
					//progress.SetStats(file_upload_limit);
					//break;
					//progress.toggleCancel(true);
					//SetStats
					//this.StopUpload();
				}
			else
				{
					document.getElementById("image_uploads").style.display = "block";
					//return true;
				}

	}
function removeElement(parent,div){
var cnt ;
var d1=document.getElementById(parent);
var d2=document.getElementById(div);
d1.removeChild(d2);
chkImgCount();
removeHiddenElement(div);
}
function addHiddenElement(src) {
	var a = ImageFolderName+"/files/uploads/thumbs/";
	var b = a.length;

	var c = src.substring(b);
	var d = c.substr(0,43);
	var newelem = document.createElement("input");
	newelem.type = "hidden";
	newelem.id = 'img_'+d;
	newelem.name = "uplarr[]";

	document.getElementById("hiddenvals").appendChild(newelem);
	newelem.value = src;
}
function addHiddenElementForName(src, src1) {

	var a = "files/uploads/thumbs/";
	var b = a.length;
	var c = src1.substring(b);
	var d = c.substr(0,43);
	var newelem = document.createElement("input");
	newelem.type = "hidden";
	newelem.id = 'imgori_'+d;
	newelem.name = "upl_original[]";
	document.getElementById("hiddenoriginalvals").appendChild(newelem);
	newelem.value = src;
}

function removeHiddenElement(src) {
	src =  src.substr(0,43);
	var d1 = document.getElementById("hiddenvals");
	req_items = d1.getElementsByTagName("input");
	var d2 = document.getElementById("img_"+src);
	d1.removeChild(d2);

	var d1 = document.getElementById("hiddenoriginalvals");
	req_items = d1.getElementsByTagName("input");
	var d2 = document.getElementById("imgori_"+src);
	d1.removeChild(d2);
	}
function fadeIn(element, opacity) {
	var reduceOpacityBy = 5;
	var rate = 30;	// 15 fps


	if (opacity < 100) {
		opacity += reduceOpacityBy;
		if (opacity > 100) {
			opacity = 100;
		}

		if (element.filters) {
			try {
					element.filters.item("DXImageTransform.Microsoft.Alpha").opacity = 100 ;
			} catch (e) {
				// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
				element.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + 100 + ')';
			}
		} else {
			element.style.opacity = opacity / 100;
		}
	}

	if (opacity < 100) {
		setTimeout(function () {
			fadeIn(element, opacity);
		}, rate);
	}
}



/* ******************************************
 *	FileProgress Object
 *	Control object for displaying file info
 * ****************************************** */

function FileProgress(file, targetID) {
	this.fileProgressID = "divFileProgress";

	this.fileProgressWrapper = document.getElementById(this.fileProgressID);
	if (!this.fileProgressWrapper) {
		this.fileProgressWrapper = document.createElement("div");
		this.fileProgressWrapper.className = "progressWrapper";
		this.fileProgressWrapper.id = this.fileProgressID;

		this.fileProgressElement = document.createElement("div");
		this.fileProgressElement.className = "progressContainer";

		var progressCancel = document.createElement("a");
		progressCancel.className = "progressCancel";
		progressCancel.href = "#";
		progressCancel.style.visibility = "hidden";
		progressCancel.appendChild(document.createTextNode(" "));

		var progressText = document.createElement("div");
		progressText.className = "progressName";
		progressText.appendChild(document.createTextNode(file.name));

		var progressBar = document.createElement("div");
		progressBar.className = "progressBarInProgress";

		var progressStatus = document.createElement("div");
		progressStatus.className = "progressBarStatus";
		progressStatus.innerHTML = "&nbsp;";

		this.fileProgressElement.appendChild(progressCancel);
		this.fileProgressElement.appendChild(progressText);
		this.fileProgressElement.appendChild(progressStatus);
		this.fileProgressElement.appendChild(progressBar);

		this.fileProgressWrapper.appendChild(this.fileProgressElement);

		document.getElementById(targetID).appendChild(this.fileProgressWrapper);
		fadeIn(this.fileProgressWrapper, 0);

	} else {
		this.fileProgressElement = this.fileProgressWrapper.firstChild;
		this.fileProgressElement.childNodes[1].firstChild.nodeValue = file.name;
	}

	this.height = this.fileProgressWrapper.offsetHeight;

}
FileProgress.prototype.setProgress = function (percentage) {
	this.fileProgressElement.className = "progressContainer green";
	this.fileProgressElement.childNodes[3].className = "progressBarInProgress";
	this.fileProgressElement.childNodes[3].style.width = percentage + "%";
};
FileProgress.prototype.setComplete = function () {
	this.fileProgressElement.className = "progressContainer blue";
	this.fileProgressElement.childNodes[3].className = "progressBarComplete";
	this.fileProgressElement.childNodes[3].style.width = "";

};
FileProgress.prototype.setError = function () {
	this.fileProgressElement.className = "progressContainer red";
	this.fileProgressElement.childNodes[3].className = "progressBarError";
	this.fileProgressElement.childNodes[3].style.width = "";

};
FileProgress.prototype.setCancelled = function () {
	this.fileProgressElement.className = "progressContainer";
	this.fileProgressElement.childNodes[3].className = "progressBarError";
	this.fileProgressElement.childNodes[3].style.width = "";

};
FileProgress.prototype.setStatus = function (status) {
	this.fileProgressElement.childNodes[2].innerHTML = status;
};

FileProgress.prototype.toggleCancel = function (show, swfuploadInstance) {
	this.fileProgressElement.childNodes[0].style.visibility = show ? "visible" : "hidden";
	if (swfuploadInstance) {
		var fileID = this.fileProgressID;
		this.fileProgressElement.childNodes[0].onclick = function () {
			swfuploadInstance.cancelUpload(fileID);
			return false;
		};
	}
};
