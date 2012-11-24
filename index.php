<html>
<head>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<!--BOOTSTRAP-->
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

<style type="text/css">
body { background-color: rgb(0,0,30); font-family: sans-serif; margin: 0; }
.image { height: 100%; margin: 0; text-align: center; }
.image img { height: 100%; }
.instructions { 
	position: absolute; right: 0; padding: 20px;
	color: white; text-align: center; font-size: 35px; line-height: 25px;
	background-color: rgba(255,255,255,.2);
	border-radius: 20px;

	-webkit-transform:rotate(90deg);

	}
</style>

</head>
<body>
<div class=instructions data-toggle="modal" data-target="#config"></div>
<div class=image></div>

<div id=config class="modal hide fade span2">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3>Config</h3>
	</div>
	<div class="modal-body">  		
  		<form onsubmit="return saveTag();">
  			<input type="text" class="input-block-level" placeholder="#tag" id=tagText onkeyup="updateTag()">
  			<input type="text" class="input-block-level" placeholder="Google Drive document URL" id=GDDText onkeyup="updateGDD()">
  			<input type="submit" value="Submit" style="display:none;">
  		</form>
  		
  	</div>
  	<div class="modal-footer">
  		<div class=resetCookies>
  			<a href="#" class="btn btn-danger" onclick="resetCookies();" style="float: left">Reset Cookies</a>
  		</div>
  		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<a href="#" class="btn btn-primary" onclick="saveItems();" data-dismiss="modal">Save</a>
    </div>
</div>



</div>

<script>

var tempTag = "";
var tempGDD = "";
var GDDCookie;
var newTag = "";
var randomItemHrefOld = "";

$(document).ready(function() {
	setInterval(function() {
		cookie();
    }, 20000);
	cookie();
}); 

$(window).resize(function() {
	repositionItems();
});

function repositionItems() {
	var vo = ($(window).height()/2)-30;
	var ho = -(($(".instructions").width())/2-30);
	$(".instructions").css({"top":vo,"right":ho});
}

function imageMagic (url) {
		console.log(url);
		$.ajax({
			url : url,
            dataType: "html",
            success : function (data) {
            	
            	var pic = $("a", data);      
            	var picTrim = pic.splice(-2); 
                var elemlength = pic.length;
				var randomnum = Math.floor(Math.random()*elemlength);
				var randomitem = pic[randomnum];
				var randomItemHref = $(randomitem).attr("href");
				if (randomItemHref == randomItemHrefOld) {
					imageMagic(url);
				} else {
					var randomItemMarkup = "<img src='" + randomItemHref + "'>";
					$(".image").fadeOut('slow', function() {
    					$(".image").html("<img src=\"" + randomItemHref + "\" />");
    					$(".image").fadeIn('slow');   
				
						randomItemHrefOld = randomItemHref; 				
  					});
  				}
            }
    	});
}

function updateTag () {
	tempTag = $('input#tagText').val();
}

function updateGDD () {
	tempGDD = $('input#GDDText').val();
}

function saveItems () {
	saveTag = tempTag;
	saveGDD = tempGDD;
	$.cookie('ppTag', saveTag, { expires: 1 });
	$.cookie('ppGDD', saveGDD, { expires: 1 });
	$(".instructions").html("Instagram #" + saveTag);
	$('#config').modal('hide');
	repositionItems();
	imageMagic();
}

function cookie() {
	var tagCookie = $.cookie('ppTag');
	var GDDCookie = $.cookie('ppGDD');
	if (!tagCookie || !GDDCookie ) {
		$('#config').modal('show');
	} else {
		$(".instructions").html("Instagram #" + tagCookie);
		$("#gdd").html(GDDCookie);
	}
	//set cookie
	//$.cookie('ppTag', 'here', { expires: 1 });
	//read cookie
	//var cookie = $.cookie('the_cookie');
	repositionItems();
	imageMagic(GDDCookie);

}

function resetCookies() {
	$.cookie('ppTag',null);
	$.cookie('ppGDD',null);
}

</script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.cookie.js"></script>



</body>
</html>