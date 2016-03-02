/*
 * jQuery File Upload Plugin JS Example 8.9.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

function initFileUpload () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: urlP+'import/upload/'
    		})
    		.on('fileuploadsubmit', function (e, data) {
	    		data.formData = data.context.find(':input').serializeArray(); 
	    		if(fuVerif && !data.formData[2].value){
	    		    w2alert('Veuillez définir une année');
	    		    data.context.find('button').prop('disabled', false);
	    		    return false;
	    		}
	    		})
    		.bind('fileuploaddone', function (e, data) {
    				console.log("fileuploaddone = "+data.result);
    			})
    		.bind('fileuploadadded', function (e, data) {
                    var fileType = data.files[0].name.split('.').pop(), allowdtypes = 'csv,xls,CSV,XLS';
                    if (fuVerif && allowdtypes.indexOf(fileType) < 0) {
                    		w2alert("Le type de fichier n'est pas bon");
                        return false;
                    }
                });
   
    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            urlP+'import/result?%s'
        )
    );
    
    // Load existing files:
    $('#fileupload').addClass('fileupload-processing');
    $.ajax({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: $('#fileupload').fileupload('option', 'url'),
        dataType: 'json',
        context: $('#fileupload')[0]
    }).always(function () {
        $(this).removeClass('fileupload-processing');
    }).done(function (result) {
        $(this).fileupload('option', 'done')
            .call(this, $.Event('done'), {result: result});
    });

}
