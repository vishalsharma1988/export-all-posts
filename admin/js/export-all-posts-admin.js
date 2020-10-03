var $ = jQuery.noConflict();

$(document).ready(function( $ ) {

	var posts_screen	= $( '.edit-php.post-type-post' );
	title_action		= posts_screen.find( '.page-title-action:first' );
	title_action.after('<a href="#" class="page-title-action export-posts">'+export_all_posts.button_name.export_all_posts+'</a>');

	$('.edit-php.post-type-post .export-posts').on('click', function(e){
		
		$.ajax({
            url: export_all_posts.ajax_url,
            data: {action:'export_all_posts'},
            method: 'POST',
            success: function (res) {
            
            	/*
                 * Make CSV downloadable
                 */
            	var downloadLink = document.createElement('a');
              	var fileData = ['\ufeff'+res];

              	var blobObject = new Blob(fileData,{
     		       		type: 'text/csv;charset=utf-8;'
               	});

              	var url = URL.createObjectURL(blobObject);
              	downloadLink.href = url;
              	downloadLink.download = 'all-posts.csv';

              	/*
               	 * Actually download CSV
                 */
              	document.body.appendChild(downloadLink);
              	downloadLink.click();
              	document.body.removeChild(downloadLink);
            }
        });
	});
});