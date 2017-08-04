
(function( $ ) {
	$.bookPreview = function( element ) {
		this.$element = $( element );
		this.init();
	};
	
	$.bookPreview.prototype = {
		init: function() {
			this.$triggers = this.$element.find( ".portfolio-link" );
			this.$closeLinks = this.$element.find( ".book-preview-close" );
			
			this.open();
			this.close();
		},
		
		_getContent: function( element ) {
			var $parent = element.parents( "figure" ),

				person = "L'avis de " + $parent.data( "person" ),

				title = $parent.data( "title" ),
				author = $parent.data( "author" ),

				link = $parent.data( "link" ),
				genre = $parent.data( "genre" ),
				theme = $parent.data( "theme" ),
				rewards = $parent.data( "rewards" ),

				recommendation = $("<div/>").html( $parent.data( "recommendation" ) ),
				sources_titles = $parent.data( "sources-titles" ),
				sources_urls = $parent.data( "sources-urls" ),
				
				leslibraires_url = $parent.data( "leslibraires-url" ),
				amazon_url = $parent.data( "amazon-url"),
				fnac_url = $parent.data( "fnac-url"),
				priceminister_url = $parent.data( "priceminister-url"),
				recyclivre_url = $parent.data( "recyclivre-url"),
				ebook_url = $parent.data( "ebook-url"),
				gutenberg_url = $parent.data( "gutenberg-url"),

				leslibraires_logo = $parent.data( "leslibraires-logo" ),
				amazon_logo = $parent.data( "amazon-logo"),
				fnac_logo = $parent.data( "fnac-logo"),
				priceminister_logo = $parent.data( "priceminister-logo"),
				recyclivre_logo = $parent.data( "recyclivre-logo"),
				ebook_logo = $parent.data( "ebook-logo"),
				gutenberg_logo = $parent.data( "gutenberg-logo"),

				html = element.find( "img" );

				return {
					person: person,

					title: title,
					author: author,

					link: link,
					genre: genre,
					theme: theme,
					rewards: rewards,

					recommendation: recommendation,
					sources_titles: sources_titles,
					sources_urls: sources_urls,
					
					leslibraires_url: leslibraires_url,
					amazon_url: amazon_url,
					fnac_url: fnac_url,
					priceminister_url: priceminister_url,
					recyclivre_url: recyclivre_url,
					ebook_url: ebook_url,
					gutenberg_url: gutenberg_url,

					leslibraires_logo: leslibraires_logo,
					amazon_logo: amazon_logo,
					fnac_logo: fnac_logo,
					priceminister_logo: priceminister_logo,
					recyclivre_logo: recyclivre_logo,
					ebook_logo: ebook_logo,
					gutenberg_logo: gutenberg_logo,

					html: html
				}
		},
		
		open: function() {
			var self = this;
			self.$triggers.on( "click", function( e ) {
				e.preventDefault();
				var $a = $( this ),
					content = self._getContent( $a ),
					$details = $a.parents(".masonry-item").nextAll(".book-preview:first");

				var	$bookImage = $( ".image", $details ),

					$bookPerson = $( ".book-preview-recommender", $details ),

					$bookTitle = $( ".book-preview-title", $details ),
					$bookAuthor = $( ".book-preview-author", $details ),

					$bookLink = $( ".book-preview-invitation", $details ),
					$bookGenre = $( ".book-preview-genre", $details ),
					$bookTheme = $( ".book-preview-theme", $details ),
					$bookRewards = $( ".book-preview-rewards", $details ),

					$bookRecommendation = $( ".book-preview-recommendation", $details ),
					$bookSourcesTitles = $( ".book-preview-sources", $details ),
					$bookSourcesUrls = $( ".book-preview-sources", $details ),
					
					$bookLeslibrairesUrl = $( "#leslibraires-url", $details ),
					$bookAmazonUrl = $( "#amazon-url", $details ),
					$bookFnacUrl = $( "#fnac-url", $details ),
					$bookPriceministerUrl = $( "#priceminister-url", $details ),
					$bookRecyclivreUrl = $( "#recyclivre-url", $details ),
					$bookEbookUrl = $( "#ebook-url", $details ),
					$bookGutenbergUrl = $( "#gutenberg-url", $details );

					/*
					$bookLeslibrairesLogo = $( "#leslibraires-logo", $details ),
					$bookAmazonLogo = $( "#amazon-logo", $details ),
					$bookFnacLogo = $( "#fnac-logo", $details ),
					$bookPriceministerLogo = $( "#priceminister-logo", $details ),
					$bookRecyclivreLogo = $( "#recyclivre-logo", $details ),
					$bookEbookLogo = $( "#ebook-logo", $details ),
					$bookGutenbergLogo = $( "#gutenberg-logo", $details );
					*/
				
				$bookImage.html( content.html );

				$bookPerson.text( content.person );

				$bookTitle.text( content.title );
				if ( content.author != "" && content.author != " " ) { $bookAuthor.text( "de " + content.author ) };

				$bookLink.text( content.link );
				$bookGenre.text( content.genre );
				$bookTheme.text( content.theme );
				$bookRewards.text( content.rewards );

				$bookRecommendation.html( content.recommendation );
				$bookSourcesTitles.text( content.sources_titles );
				$bookSourcesUrls.text( content.sources_urls );
				
				if ( content.leslibraires_url != "" ) {
					$bookLeslibrairesUrl.attr( "href", content.leslibraires_url );
					$bookLeslibrairesUrl.html( "<img src=" + content.leslibraires_logo + " height=\"24\" width=\"24\"/>" );
					//$bookLeslibrairesLogo.attr( "src", content.leslibraires_logo );
				};

				if ( content.amazon_url != "" ) {
					$bookAmazonUrl.attr( "href", content.amazon_url );
					$bookAmazonUrl.html( "<img src=" + content.amazon_logo + " height=\"24\" width=\"24\"/>" );
					//$bookAmazonLogo.attr( "src", content.amazon_logo );
				};

				if ( content.fnac_url != "" ) {
					$bookFnacUrl.attr( "href", content.fnac_url );
					$bookFnacUrl.html( "<img src=" + content.fnac_logo + " height=\"24\" width=\"24\"/>" );
					//$bookFnacLogo.attr( "src", content.fnac_logo );
				};

				if ( content.priceminister_url != "" ) {
					$bookPriceministerUrl.attr( "href", content.priceminister_url );
					$bookPriceministerUrl.html( "<img src=" + content.priceminister_logo + " height=\"24\" width=\"24\"/>" );
					//$bookPriceministerLogo.attr( "src", content.priceminister_logo );
				};

				if ( content.recyclivre_url != "" ) {
					$bookRecyclivreUrl.attr( "href", content.recyclivre_url );
					$bookRecyclivreUrl.html( "<img src=" + content.recyclivre_logo + " height=\"24\" width=\"24\"/>" );
					//$bookRecyclivreLogo.attr( "src", content.recyclivre_logo );
				};

				if ( content.ebook_url != "" ) {
					$bookEbookUrl.attr( "href", content.ebook_url );
					$bookEbookUrl.html( "<img src=" + content.ebook_logo + " height=\"24\" width=\"35\"/>" );
					//$bookEbookLogo.attr( "src", content.ebook_logo );
				};

				if ( content.gutenberg_url != "" ) {
					$bookGutenbergUrl.attr( "href", content.gutenberg_url );
					$bookGutenbergUrl.html( "<img src=" + content.gutenberg_logo + " height=\"24\" width=\"24\"/>" );
					//$bookGutenbergLogo.attr( "src", content.gutenberg_logo );

				};
					
				self.$element.find( ".book-preview" ).slideUp( 600 );
				$details.slideDown( 600 );
				
			});
		},

		close: function() {
			this.$closeLinks.on( "click", function( e ) {
				e.preventDefault();
				$( this ).parent().slideUp( 600 );
				
			});
		}	
	};
	
	$(function() {

		// If we are on a laptop, there are 4 Book images per row
		if ( $( document ).width() > 768  ) {
		    $(".masonry-item:nth-of-type(4n)").after("<div class=\"book-preview\"> <a href=\"#\" class=\"book-preview-close\">Fermer</a> <div class=\"book-preview-content\"> <h2 class=\"book-preview-title\"></h2> <h4 class=\"book-preview-author\"></h4> <figure class=\"image\"></figure> <!-- Affiliation Section --> <div class=\"book-preview-affiliation\"> <h4>Acheter ce livre</h4><a target=\"_blank\" href=\"#\" id=\"amazon-url\" title=\"Acheter sur Amazon\"></a><a target=\"_blank\" href=\"#\" id=\"leslibraires-url\" title=\"Acheter sur Les Libraires\"></a><a target=\"_blank\" href=\"#\" id=\"fnac-url\" title=\"Acheter sur La Fnac\"></a><a target=\"_blank\" href=\"#\" id=\"priceminister-url\" title=\"Acheter sur PriceMinister\"></a><a target=\"_blank\" href=\"#\" id=\"recyclivre-url\" title=\"Acheter sur RecycLivre\"></a><a target=\"_blank\" href=\"#\" id=\"ebook-url\" title=\"Acheter sur EBook\"></a><a target=\"_blank\" href=\"#\" id=\"gutenberg-url\" title=\"Acheter sur Gutenberg Project\"></a></div> <!-- End Affiliation Section --> </div> <div class=\"book-preview-desc\"> <h3 class=\"book-preview-recommender\"></h3> <p class=\"book-preview-recommendation\"></p> <div class=\"book-preview-sources\"> Source(s) : <?php for ($i = 0; $i < count( $recommendation_sources_titles ); $i++) : if( $i > 0 ) : ?> | <?php endif; ?> <span> <a target=\"_blank\" href=\"<?php echo $recommendation_sources_urls[$i] ?>\"><?php echo $recommendation_sources_titles[$i] ?></a> </span> <?php endfor; ?> </div> <div class=\"book-preview-invitation\"> <a href=\"#\">Allez sur la page du livre</a> </div> </div> </div> </div>");
		// If we are on a tablet or smartphone, there is one Book per row
		} else { 
		    $(".masonry-item").after("<div class=\"book-preview\"><a href=\"#\" class=\"book-preview-close\">Close</a><div class=\"book-preview-content\"><figure class=\"image\"></figure></div><div class=\"book-preview-desc\"><h3 class=\"book-preview-title\"></h3><p class=\"book-preview-text\"></p></div></div>");
		}

		var preview = new $.bookPreview( ".portfolio-books-wrapper" );
		
	});
	
})( jQuery );