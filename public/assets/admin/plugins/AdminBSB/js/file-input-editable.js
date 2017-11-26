(function ($) {
    "use strict";
    
    var EditableFile = function (options) {

        this.init('file', options, EditableFile.defaults);


    };

     $.fn.editableutils.inherit(EditableFile, $.fn.editabletypes.abstractinput);

     $.extend(EditableFile.prototype, {
        
        fileData:[],


        getFileType: function(){

          var setting = this.options.scope.dataset;
          var option = JSON.parse(setting.option);
          return option.file_type;
        },

        getFilePath : function(data){
          
          var value = '';

          if(typeof data =='object'){            
            
            value = data[0]['file'];          
            if(typeof data[0]['thumbs'][0] !=  'undefined'){
              
              value = data[0]['thumbs'][0];
            }
          }else{
            
            value = data;
          }

          return value;
        },

        renderFilePreview:function(value){

            value = this.getFilePath(value);
            if(this.getFileType() =='image'){

              return '<img src="'+window.site.storage_url+value+'">';
            }else{

              return this.getFileType();
            }
        },
        
        /**Renders input from tpl

        @method render() 
        **/        
      
        render: function() {

         //console.log("this.$element");
         //console.log($(this.options.scope).length);
           this.$input = this.$tpl.find('input');

           this.$tpl.append('<a href="javascript:void(0);" class="open_media"><i class="material-icons">mode_edit</i></a>');
       
          // console.log(this.options.scope.dataset);
          var setting = this.options.scope.dataset;
          var option = JSON.parse(setting.option);
          this.$tpl.attr('id','setting-'+setting.pk);
          var _this = this;
          var media_data ={};

        

          // $(_this.options.scope).on('hidden',function(e,reason){
             
          //     //if(reason =='onblur')
          //       //$(_this.options.scope).editable('show');
          // });

          media_data['title'] = setting.originalTitle;
          media_data['name']= 'setting_file_value';

          if(typeof option.image_width != 'undefined' && typeof option.image_height != 'undefined'){

             media_data['thumb'] = [{w:option.image_width,h:option.image_height,title:setting.originalTitle}];
          }

          media_data['maxFilesize'] = 1;

          if(typeof option.file_type != 'undefined' && option.file_type =='image'){

            media_data['acceptedFiles'] = '.jpeg,.jpg,.png,.gif';
          }

          
          this.$tpl.find('.open_media').click(function(){
            $.LaravelMedia.openModal(_this.$tpl,media_data,function(data){
                _this.fileData = data;
                $(_this.options.scope).editable('show');

                var _thumb = $.LaravelMedia.prepareThumbHtml(data[0],'value',0);

                _this.$tpl.append(_thumb);

                var value = _this.getFilePath(data);

                _this.$tpl.find('.open_media').prepend(_this.renderFilePreview(value));
                //_this.$tpl.closest('form').submit();
            });            
          });



        },

        input2value:function(){
          // console.log(this.fileData);
          // console.log("hello.....");
          return this.fileData;
        },

        activate: function() {
        },

         /**
        Default method to show value in element. Can be overwritten by display option.
        
        @method value2html(value, element) 
        **/
        value2html: function(value, element) {

            console.log(value);
            console.log("value");
            if(!value) {
                $(element).empty();
                return; 
            }
            $(element).html(this.renderFilePreview(value));
        },

         /**
        Gets value from element's html
        
        @method html2value(html) 0
        **/        
        html2value: function(html) {        
        

          return null;  
        },
        value2input: function(value) {
          
          return this.fileData;
        	
        },

        validateEmail: function(email) {
    		    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    		    return re.test(email);
    		},

        /**
        Converts value to string. 
        It is used in internal comparing (not for sending to server).
        
        @method value2str(value)  
       **/
       value2str: function(value) {
       		console.log(3);
           return value;
       }, 
       

       autosubmit: function() {
           return false;
       } 

       // destroy: function() {
            
       //      if(this.$input.data('role') =='tagsinput') {
       //          this.$input.tagsinput('destroy');
       //      }
       //  },

     });

     EditableFile.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, {
        tpl: '<div class="file_wrapper"><label><img src=""><input type="text" name="editable_file" value="" class="form-control input-small editable_file"></label></div>',
             
        inputclass: '',
        onblur:'ignore',
        
    });

     $.fn.editabletypes.file = EditableFile;

}(window.jQuery));