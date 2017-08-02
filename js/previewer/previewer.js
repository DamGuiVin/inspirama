(function( $ ) {
	$.imagePreview = function( element ) {
		this.$element = $( element );
		this.init();
	};
	
	$.imagePreview.prototype = {
		init: function() {
			this.$triggers = this.$element.find( ".image-link" );
			this.$closeLinks = this.$element.find( ".image-details-close" );
			
			this.open();
			this.close();
		},
		
		_getContent: function( element ) {
			var $parent = element.parent(),
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
					$li = $a.parents( "li" ),
					$details = $( ".image-details", $li ),
					$contentImage = $( ".image", $details ),
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
		var preview = new $.imagePreview( "#books-portfolio-wrapper" );
		
	});
	
})( jQuery );
