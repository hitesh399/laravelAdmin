
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('meta-title','Admin Panel')</title>
    <!-- Favicon-->
    <link rel="icon" href="{!! asset('favicon.ico') !!}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{!! asset(elixir('assets/admin/css/file-drag-drop.base.css')) !!}" rel="stylesheet">
      
      <script type="text/javascript">
          window.site = {
            'site_url':'{!!url('/')!!}',
            'base_url':'{!!asset('/')!!}',
            'admin_url':'{!!url('/admin')!!}',
            'timezone':'{!!Cache::get('settings.APP_TIMEZONE')!!}',
            'date_format':'{!!Cache::get('settings.date_format')!!}',
            'time_format':'{!!Cache::get('settings.time_format')!!}',
            'datetime_format':'{!!Cache::get('settings.datetime_format')!!}',
          };

    </script>
      <style type="text/css">
        
      .cropper-panel .container {
      max-width: 640px;
      margin: 20px auto;
    }

    .cropper-panel img {
      width: 100%;
    }
    .imageBox{
      
      float: left;
    }

    .width_50_50{
      width: 50%;
    }

    .imageBox .inner{
      margin: 15px;
      overflow: hidden;
    }
    .cropper-panel{
      width: 100%;
      float: left;
    }
    .thumb_title{

      display: block;
    padding-bottom: 10px;
    padding-left: 10px;
    border-bottom: 1px solid #ccc;
    clear: both;
    margin: 0 15px;
    }

    html, body {
    height: auto;
    float: left;
    width: 100%;
    }
    #actions {
      margin: 2em 0;
    }


    /* Mimic table appearance */
    div.table {
      display: table;
    }
    div.table .file-row {
      display: table-row;
    }
    div.table .file-row > div {
      display: table-cell;
      vertical-align: top;
      border-top: 1px solid #ddd;
      padding: 8px;
    }
    div.table .file-row:nth-child(odd) {
      background: #f9f9f9;
    }



    /* The total progress gets shown by event listeners */
    #total-progress {
      opacity: 0;
      transition: opacity 0.3s linear;
    }

    /* Hide the progress bar when finished */
    #previews .file-row.dz-success .progress {
      opacity: 0;
      transition: opacity 0.3s linear;
    }

    /* Hide the delete button initially */
    #previews .file-row .delete {
      display: none;
    }

    /* Hide the start and cancel buttons and show the delete button */

    #previews .file-row.dz-success .start,
    #previews .file-row.dz-success .cancel {
      display: none;
    }
    #previews .file-row.dz-success .delete {
      display: block;
    }


</style>
    
      
</head>
<body>
<div class="toggle-button btn is_upload hide">back to Upload</div>
    <div id="dropzoneDiv">
      {!!Form::open(['url'=>'sfgdsjgj','method'=>'POST','class'=>'dropzone','id'=>'dropzone'])!!}
      
      {!!Form::close()!!}
      <div class="table table-striped" class="files" id="previews">

      <div id="template" class="file-row">
        <!-- This is used as the file preview template -->
        <div>
            <span class="preview"><img data-dz-thumbnail /></span>
        </div>
        <div>
            <p class="name" data-dz-name></p>
            <strong class="error text-danger" data-dz-errormessage></strong>
        </div>
        <div>
            <p class="size" data-dz-size></p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
              <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
            </div>
        </div>
        <div>
          <button class="btn btn-primary start">
              <i class="glyphicon glyphicon-upload"></i>
              <span>Start</span>
          </button>
          <button data-dz-remove class="btn btn-warning cancel">
              <i class="glyphicon glyphicon-ban-circle"></i>
              <span>Cancel</span>
          </button>
          <button data-dz-remove class="btn btn-danger delete">
            <i class="glyphicon glyphicon-trash"></i>
            <span>Delete</span>
          </button>
        </div>
      </div>

    </div>
   </div>   

  <div class="hide" style="margin-top: 20px;" id="cropperDiv">
    <div class="cropper-panel"></div>
  </div>


<script type="text/javascript" src="{!!asset(elixir('assets/admin/js/file-drag-drop.base.js'))!!}"></script>
<script type="text/javascript" src="{!!asset('assets/admin/js/file-manager.js')!!}"></script>


<script type="text/javascript">
var requestData = {!!json_encode(Request::all())!!};

var fm = new fileManager(requestData);
fm.load();

$(function () {


  $('.toggle-button').click(function(){

      if($('#cropperDiv').is(':visible')){

        $('#cropperDiv').addClass('hide');
        $('#dropzoneDiv').removeClass('hide'); 

        $(this).html('Back to Crop Image');
      }
      else{

        var no_of_file = fm.dropzone.files.length;       
        if(!no_of_file){
          $('.cropper-panel').html('');
          $('.cropper-panel img').cropper('destroy'); 
          $('#cropperDiv').addClass('hide');
          $('#dropzoneDiv').removeClass('hide'); 
          $(this).addClass('hide');
        }else{
          
          $('#cropperDiv').removeClass('hide');
          $('#dropzoneDiv').addClass('hide');
          $(this).html('Back to Upload');
        }
      }   
  });
});
  
</script>
</body>
</html>