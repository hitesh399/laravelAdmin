$.LaravelMedia = {};

$.LaravelMedia = {


	elms:[],

	modalHtml: function(data){

		var modal = '<div class="modal fade" id="file-manager-modal">'+
		    '<div class="modal-dialog modal-lg">'+
		        '<div class="modal-content">'+
		            '<div class="modal-header">'+
		                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
		                '<h4 class="modal-title">'+data.title+'</h4>'+
		            '</div>'+
		            '<div class="modal-body">'+data.content+
		            '</div>'+
		            '<div class="modal-footer">'+
		                '<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>'+
		                '<button type="button" class="btn btn-info media-action">Save changes</button>'+
		            '</div>'+
		        '</div>'+
		    '</div>'+
		'</div>';


		return modal;
	},
	/**
	 * This function use to open the File upload media Modal Box.
	 * @param  {object} _this Element jquery instacne
	 * @param  {object} data  file data
	 * {
	 * 	 title: Image title,
	 * 	 name: input name 
	 * 	 thumb: {[w,h,title]} thumbnail details
	 * 	 maxFilesize: no of file which can be select in one action.
	 * 	 acceptedFiles: accepted file extension
	 * }
	 * @return {function|Object}	Callback function , which will be execute when the file has been uploaded.
	 */
	openModal:function(_this,data,_callback){
		
		var popup_data = {};
		data = data === undefined ? {} : data;
		_this  = $(_this);
		popup_data['title'] = data && data.title ? data.title  : '';
		data.element_id = _this.attr('id');
		
		
		var element_data = jQuery.extend(true, {}, data);
		element_data._this = _this;
		element_data.callback = _callback;

		this.elms[data['name']] = element_data;		

		var url = this.getUrl()+'?'+$.param(data);

		popup_data.content = '<iframe  width="100%" id="media-iframe" height="auto" src="'+url+'" onload="$.LaravelMedia.resizeIframe()"></iframe>';
		if($('body').find('#file-manager-modal').length){

			$('body').find('#file-manager-modal').find('.modal-title').html(popup_data.title);
			$('body').find('#file-manager-modal').find('.modal-body').html(popup_data.content);
		}else{

			var modal_html = this.modalHtml(popup_data);
			$('body').append(modal_html);
		}

		$('body').find('#file-manager-modal').modal('show');
	},

	getUrl: function()
	{

		return window.site.site_url+'/files-manager';
	},
	/**
	 * This method calls when file has been uploaded.
	 * @param  {object} data        uploaded file details
	 * @param  {object} requestData request file details
	 * @return {void}         none
	 */
	closedModal: function (data,requestData){

		$('body').find('#file-manager-modal').modal('hide');

		var inputName = requestData.name;

		if(typeof this.elms[inputName]['callback'] =="function"){

			this.elms[inputName]['callback'](data,requestData);

			return;
		}

		this.listWithNameHtml(data,requestData);
	},

	listWithNameHtml: function(data,requestData)
	{
		var htm = '';
		var _this = this;


		var inputName = requestData.name;

		var elm = _this.elms[inputName]['_this'];	

		//_this.elms[inputName]['callback'](data,requestData);	

		$.each(data,function(index,file){

			var imageUrl = file.base_url+file.file;
			var name = file.fileOrignalName;
			var name_last_index = name.lastIndexOf('.');
			var onlyName = name.substring(0, name_last_index);		
			

			var thumbs_input = _this.prepareThumbHtml(file,inputName,index);

			thumbs_input +='<input type="hidden" class="form-control" value="'+name+'" name="'+inputName+'['+index+'][org_name]"/>';

			htm += '<div class="media mb-1">'+thumbs_input+
	        '<a class="media-left waves-light">'+
	            '<img class="rounded-circle" width="50px" src="'+imageUrl+'" alt="Generic placeholder image">'+
	        '</a>'+
	        '<div class="media-body">'+
	            '<h4 class="media-heading"><input type="text" class="form-control" value="'+onlyName+'" name="'+inputName+'['+index+'][name]"/></h4>'+
	        '</div>'+
	    	'</div>';
    	});

		console.log(elm.length);
		console.log(htm);
    	
		if(elm.next('.media-data').length ==0){
			console.log("############");
			elm.after('<div class="media-data"></div>');
		}
    	elm.parent().find('.media-data').html(htm);
	},

	prepareThumbHtml: function(file,inputName,index){

		var thumbs = typeof file.thumbs != "undefined"?file.thumbs:false;
		var thumbs_input = '';
		if(thumbs){

			$.each(thumbs,function(t_index,t_value){

				thumbs_input += '<input type="hidden" value="'+t_value+'" name="'+inputName+'['+index+'][thumb]['+t_index+']">';
			});
		}

		return thumbs_input;
	},

	resizeIframe: function(){

		var obj = document.getElementById('media-iframe');
		console.log(obj.contentWindow.document.body.scrollHeight);
		console.log('obj.contentWindow.document.body.scrollHeight');
		var h = obj.contentWindow.document.body.scrollHeight ===0 ? 150 : obj.contentWindow.document.body.scrollHeight+20;
		obj.style.height = (h+40) + 'px';
	}
}

$(function () {

	$('body').on('click','.media-action',function(){

		document.getElementById('media-iframe').contentWindow.fm.doUpload();
	});
});