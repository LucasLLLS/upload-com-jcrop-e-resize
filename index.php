<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>

	<script src="js/jquery.min.js"></script>
	<script src="js/Jcrop.min.js"></script>
	<script>

	function readURL(input) {

	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('#target').attr('src', e.target.result);

	            setTimeout(function(){
	            $('input[name=imgInitW]').val($('#target').width());
	            $('input[name=imgInitH]').val($('#target').height());
	            $('input[name=imgCurrW]').val($('canvas').width());
	            $('input[name=imgCurrH]').val($('canvas').height());

	            }, 1000);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	function callCropper(){

		var d = document, ge = 'getElementById';
        
        $('#interface').on('cropmove cropend',function(e,s,c){
          $('input[name=x]').val(c.x);
          $('input[name=y]').val(c.y);
          $('input[name=w]').val(c.w);
          $('input[name=h]').val(c.h);
        });
        
        // Most basic attachment example
        $('#target').Jcrop({
        	aspectRatio: 1,
          	setSelect: [ 175, 100, 400, 300 ]
        },function(){
		  var jcrop_api = this;
		  new $.Jcrop.component.Thumbnailer(jcrop_api,{ width: 130, height: 130 });
		});
        
        $('#text-inputs').on('change','input',function(e){
          $('#target').Jcrop('api').animateTo([
            parseInt(d[ge]('crop-x').value),
            parseInt(d[ge]('crop-y').value),
            parseInt(d[ge]('crop-w').value),
            parseInt(d[ge]('crop-h').value)
          ]);
        });
	}

	jQuery(function($){

		$("#upload").change(function(){
		    readURL(this);
		    callCropper();
		});
        
      });
	</script>
	
	<link rel="stylesheet" href="demos/demo_files/main.css">
    <link rel="stylesheet" href="demos/demo_files/demos.css">
    <link rel="stylesheet" href="css/Jcrop.css">
    <style>
      #text-inputs { margin: 10px 8px 0; }
      .input-group { margin-right: 1.5em; }
      .nav-box { width: 748px; padding: 0 !important; margin: 4px 0; background-color: #f8f8f7; }

      canvas, .jcrop-active{
      	max-width: 500px !important;
      	height: auto !important;
      }

      canvas img{
      	max-width: 100% !important;
      	height: auto !important;
      }
      
    </style>

<body>

	<form enctype="multipart/form-data" method="post" action="upload.php">

		x<input type="text" name="x">
		y<input type="text" name="y">
		w<input type="text" name="w">
		h<input type="text" name="h">

		<br>

		imgInitW <input type="text" name="imgInitW">
		imgInitW <input type="text" name="imgInitH">
		imgCurrW <input type="text" name="imgCurrW">
		imgCurrW <input type="text" name="imgCurrH">

		<input type="file" id="upload" name="fileToUpload">

		<br><br>
		<input type="submit" value="Upload" />
	</form>

	<div id="interface" class="page-interface">
		<img src="" id="target">
	</div>


</body>
</html>