<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('meta-title','Admin Panel')</title>
    <!-- Favicon-->
    <link rel="icon" href="{!! asset('favicon.ico') !!}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <link href="{!!asset('assets/admin/css/fonts.css') !!}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="{!! asset('assets/admin/css/_bootstrap.css') !!}" rel="stylesheet">

    <style type="text/css">
        
        .img-place-holder{
            width: 200px; 
            height: 200px;
            margin: auto;
            overflow: hidden;
            max-width: 100%;       

        }
        .box{
            background: #f5f5f5;
        }
        .image-wrapper{
          margin: 10px;
          max-height: 180px;
          overflow: hidden;
        }

    </style>
</head>
<body>



    <a href="#" id="browseButton">Select files</a>
    <div id="results" class="panel"></div>
    <div class="alert-box secondary"></div>
    <!-- Jquery Core Js -->
    <script src="{!! asset(mix('assets/admin/js/resumable.template.base.min.js')) !!}"></script>

    <script>

    var results = $('#results');

        var r = new Resumable({
          target: '{!!url('files-uploader')!!}',
          fileParameterName:'file',
          headers:{

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        })


        r.assignBrowse(document.getElementById('browseButton'));

        r.on('fileSuccess', function(file,data){
            console.log(1);
           $('[data-uniqueId=' + file.uniqueIdentifier + ']').find('.progress').addClass('success');

        });
        r.on('fileProgress', function(file){
           // console.debug('fileProgress', file);
           console.log(2);
          var progress = Math.floor(file.progress() * 100);
          $('[data-uniqueId=' + file.uniqueIdentifier + ']').find('.meter').css('width', progress + '%');
          $('[data-uniqueId=' + file.uniqueIdentifier + ']').find('.meter').html('&nbsp;' + progress + '%');

        });
        r.on('fileAdded', function(file, event){
            r.upload();
             displayFileList(file);
            //console.debug('fileAdded', event);
        });
        r.on('fileRetry', function(file){
            //console.debug('fileRetry', file);
            console.log(3);
          });
        r.on('fileError', function(file, message){
           console.log(4);
            //console.debug('fileError', file, message);
             $('[data-uniqueId=' + file.uniqueIdentifier + ']').remove();
          });
        r.on('uploadStart', function(){
            //console.debug('uploadStart');
            $('.alert-box').text('Uploading....');
        });
        r.on('complete', function(data,d){
            console.debug('complete');
            $('.alert-box').text('Done Uploading');
            console.log(5);
            
        });
        r.on('progress', function(message, file){
            console.debug('progress');
            console.log(message, file);
          });
        r.on('error', function(message, file){
          //$('[data-uniqueId=' + file.uniqueIdentifier + ']').remove();
          console.log(7);
          var message =  JSON.parse(message);
          alert(message.message);
          //alert(message.message);
          //console.debug('error', message, file);
         // r.cancel();
        });
        r.on('pause', function(){
           // console.debug('pause');
           console.log(8);
        });
        r.on('cancel', function(){
           // console.debug('cancel');
           console.log(10);
        });

        
        

        function displayFileList(file){

          var reader  = new FileReader();
          reader.onload = function(e)  {
         
            var image = document.getElementById("img_"+file.uniqueIdentifier);
            image.src = e.target.result;
          }
           var template =
            '<div  class= "col-lg-3 col-md-4 col-xs-6 " data-uniqueid="' +file.uniqueIdentifier + '"><div class="box">' +
            '<div class="img-place-holder"><div class="image-wrapper"><img class="img-fluid img-thumbnail img-responsive" src="" id="img_'+file.uniqueIdentifier+'" /></div></div>'+
            //'<div class="fileName">' + file.fileName + ' (' + file.file.type + ')' + '</div>' +
            '<div class="large-6 right deleteFile">X</div>' +
            '<div class="progress large-6">' +
            '<span class="meter" style="width:0%;"></span>' +
            '</div>' +
            '</div></div>';            
            results.append(template);
           reader.readAsDataURL(file.file); 
        }

        
        </script>
    
</body>

</html>