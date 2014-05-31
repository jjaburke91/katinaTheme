<!-- Page Displaying CV -->


<?php get_header(); ?>

<?php wp_enqueue_script("jquery"); ?>




<div class="content-area">
	
    <object id="object-pdf" data="http://www.jordanmuir.co.uk/wp-content/uploads/Jordan_Muir_CV.pdf" type="application/pdf">
        <embed src="http://www.jordanmuir.co.uk/wp-content/uploads/Jordan_Muir_CV.pdf" type="application/pdf" style="min-width: 1px"/>
    </object>	
	<!--
	"ww.jordanmuir.co.uk/wp-content/uploads/Jordan_Muir_CV.pdf" viewer_width=100% viewer_height=800px fullscreen=false download=true print=true openfile=false]
	-->
</div>

<script type="text/javascript">
	
	var sizePdf = function() {
		var javaHeight = jQuery(document).height() / 1.32;
		jQuery("#object-pdf").height( javaHeight );
		
	};
	
	jQuery( document ).ready( function() {
		sizePdf();
	} );
	
	jQuery(window).resize( function() {
		sizePdf();
		console.log("resizing");
		console.log(jQuery(document).height());
	} );
	
	
</script>

