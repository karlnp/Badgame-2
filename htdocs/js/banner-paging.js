window.bannerPage = 0;

function getNextBanners(){
	window.bannerPage++;
	loadBanners();
}

function getPreviousBanners(){
	if(window.bannerPage > 0){
		window.bannerPage--;
		loadBanners();
	}
}

function loadBanners(){
	$.ajax({
		dataType: 'json',
		success: function(response){
			var banners = response['banners'];

			if(banners.length){
				var bannerContent = $('#bannerContent');
				$(bannerContent).html('');

				$(banners).each(function(){
					var bannerHtml = '<img src="' + this['filename'] + '" title="Uploaded by ' + this['uploader_name'] + '" style="margin: 5px" />';
					$(bannerContent).append(bannerHtml);
				});	
			} else {
				alert('No more banners.');
				window.bannerPage--;
			}
		},
		url: '/index.php?action=banners&sa=list_ajax&page=' + window.bannerPage,
	});	
}
