
(function( $ ) {
	$.imagePreview = function( element ) {
		this.$element = $( element );
		this.init();
	};
	
	$.imagePreview.prototype = {
		init: function() {
			this.$triggers = this.$element.find( ".portfolio-link" );
			this.$closeLinks = this.$element.find( ".image-details-close" );
			
			this.open();
			this.close();
		},
		
		_getContent: function( element ) {
			var $parent = element.parents( "figure" ),
				title = $parent.data( "title" ),
				desc = $parent.data( "desc" ),
				html = element.html();
				
				return {
					title: title,
					desc: desc,
					html: html
				}
		},
		
		open: function() {
			var self = this;
			self.$triggers.on( "click", function( e ) {
				e.preventDefault();
				var $a = $( this ),
					content = self._getContent( $a ),
					$details;

				$details = $a.parents("li").nextAll(".image-details:first");

				var	$contentImage = $( ".image", $details ),
					$detailsTitle = $( ".image-details-title", $details ),
					$detailsText = $( ".image-details-text", $details );
				
				$contentImage.html( content.html );
				$detailsTitle.text( content.title );
				$detailsText.text( content.desc );
				
				self.$element.find( ".image-details" ).slideUp( "fast" );
				$details.slideDown( "fast" );
				
			});
		},

		close: function() {
			this.$closeLinks.on( "click", function( e ) {
				e.preventDefault();
				$( this ).parent().slideUp( "fast" );
				
			});
		}	
	};
	
	$(function() {

		// If we are on a laptop, there are 4 Book images per row
		if ( $( document ).width() > 768  ) {
		    $(".masonry-item:nth-of-type(4n)").after("<div class=\"image-details\"><a href=\"#\" class=\"image-details-close\">Close</a><div class=\"image-details-content\"><figure class=\"image\"></figure></div><div class=\"image-details-desc\"><h3 class=\"image-details-title\"></h3><p class=\"image-details-text\"></p></div></div>");
		// If we are on a tablet or smartphone, there is one Book per row
		} else { 
		    $(".masonry-item").after("<div class=\"image-details\"><a href=\"#\" class=\"image-details-close\">Close</a><div class=\"image-details-content\"><figure class=\"image\"></figure></div><div class=\"image-details-desc\"><h3 class=\"image-details-title\"></h3><p class=\"image-details-text\"></p></div></div>");
		}

		var preview = new $.imagePreview( ".portfolio-books-wrapper" );
		
	});
	
})( jQuery );