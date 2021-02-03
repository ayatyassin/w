<?php
/**
 * The main template file
 */

global $post;  
$todoslosthememods=get_theme_mods();
//print_r($todoslosthememods); 
$customheader=0;
foreach($todoslosthememods as $key =>
 $value)
	{
	   if(preg_match('/^nt_featured_pages/', $key))
	   {
		   if ($customheader==0){
				$menunumber=str_replace("nt_featured_pages","",$key);						
				if (in_array("123454321", $value)) { //Assigned to homepage
					get_header("custom$menunumber");
					$customheader=1;
				}
				if (in_array("0", $value)) { //Assigned to no pages
					//get_header("custom$menunumber");
					$customheader=0;
				}
		   } 			
	   }
	}	
if ($customheader==0) get_header(); 
?>


<div class="wrap">

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">


			
<div data-drag="P110" id="P110" class="simblaEL containerHolder">
<div data-title="Container" id="ii06ih" class="container">
<div data-drag="P221" id="P221" class="simblaEL simblaImg">
<span id="tgimg-1">
<img <?php if( get_theme_mod( "tgimg-1") != "" ) {echo "src='".get_theme_mod( "tgimg-1")."'";} else {echo "src='//d33rxv6e3thba6.cloudfront.net/2015/11/56711c4496eb08c9070977df/32174-l90ad7.png'";} ?>
 alt="logo_purple_2.png" data-id="" title="logo_purple_2.png"  id="i1s3bi" />
</span>
</div>
<div id="i403dl">
<h1 id="ii726h" data-highlightable="1" class="gjs-comp-selected">
Our Programs</h1>
</div>
<div data-drag="P114" id="P114" class="simblaEL tcH">
<div id="ikhpt4" class="textContainer H1">
</div>
</div>
<div data-drag="P118" id="P118" data-title="Row" class="row simblaEL rDivider">
<div data-colsize="3" data-title="Column" class="sDivider col-md-3 index0">
<div data-drag="P683" id="P683" data-title="Row" data-border-type="All" data-group-id="tyty" class="row simblaEL rDivider">
<div data-colsize="12" data-title="Column" class="sDivider col-md-12 index0">
<div data-drag="P694" id="P694" class="simblaEL simblaImg">
<span id="tgimg-2">
<img <?php if( get_theme_mod( "tgimg-2") != "" ) {echo "src='".get_theme_mod( "tgimg-2")."'";} else {echo "src='//d33rxv6e3thba6.cloudfront.net/2016/11/581b45e2d93877bd681e08aa/28315-1bw0amh.jpeg'";} ?>
 alt="1.jpeg" data-id="" title="1.jpeg" />
</span>
</div>
<div data-drag="P687" id="P687" class="simblaEL tcH">
<div data-border-type="All" data-group-id="e" id="iuew8e" class="textContainer H2">
<h2>
One trial lesson</h2>
</div>
</div>
<div data-drag="P689" id="P689" class="simblaEL tcH">
<div data-border-type="All" data-group-id="f" id="i5m6i8" class="textContainer H3">
<h3>
Free</h3>
</div>
</div>
<div data-drag="P703" id="P703" class="simblaEL tc">
<div data-border-type="All" data-group-id="gyyy" id="iqytdk" class="textContainer">
<p>
Want to add your own creative touch? Make your own theme! You have many tools to play around with, like colors schemes, icons, fonts, images, and backgrounds.
</p>
</div>
</div>
<button type="submit" data-drag="P693" id="P693" class="simblaEL btn">
Subscribe</button>
</div>
</div>
<div data-drag="P122" id="P122" class="simblaEL tcH">
</div>
<div data-drag="P124" id="P124" class="simblaEL tcH">
</div>
<div data-drag="P128" id="P128" class="simblaEL tcH">
</div>
<div data-drag="P142" id="P142" class="simblaEL tcH">
</div>
</div>
<div data-colsize="3" data-title="Column" class="sDivider col-md-3 index1">
<div data-drag="P695" id="P695" data-title="Row" data-border-type="All" data-group-id="tyty" class="row simblaEL rDivider">
<div data-colsize="12" data-title="Column" class="sDivider col-md-12 index0">
<div data-drag="P697" id="P697" class="simblaEL simblaImg">
<span id="tgimg-3">
<img <?php if( get_theme_mod( "tgimg-3") != "" ) {echo "src='".get_theme_mod( "tgimg-3")."'";} else {echo "src='//d33rxv6e3thba6.cloudfront.net/2016/11/581b45e2d93877bd681e08aa/28315-13tok9w.jpeg'";} ?>
 alt="1.jpeg" data-id="" title="1.jpeg" />
</span>
</div>
<div data-drag="P699" id="P699" class="simblaEL tcH">
<div data-border-type="All" data-group-id="e" id="ivnqpi" class="textContainer H2">
<h2>
2 month plan</h2>
</div>
</div>
<div data-drag="P701" id="P701" class="simblaEL tcH">
<div data-border-type="All" data-group-id="f" id="iew6vr" class="textContainer H3">
<h3>
$40</h3>
</div>
</div>
<div data-drag="P718" id="P718" class="simblaEL tc">
<div data-border-type="All" data-group-id="gyyy" id="i05sws" class="textContainer">
<p>
Want to add your own creative touch? Make your own theme! You have many tools to play around with, like colors schemes, icons, fonts, images, and backgrounds.
</p>
</div>
</div>
<button type="submit" data-drag="P705" id="P705" class="simblaEL btn">
Subscribe</button>
</div>
</div>
<div data-drag="P146" id="P146" class="simblaEL tcH">
</div>
<div data-drag="P162" id="P162" class="simblaEL tcH">
</div>
</div>
<div data-colsize="3" data-title="Column" class="sDivider col-md-3 index2">
<div data-drag="P706" id="P706" data-title="Row" data-border-type="All" data-group-id="tyty" class="row simblaEL rDivider">
<div data-colsize="12" data-title="Column" class="sDivider col-md-12 index0">
<div data-drag="P708" id="P708" class="simblaEL simblaImg">
<span id="tgimg-4">
<img <?php if( get_theme_mod( "tgimg-4") != "" ) {echo "src='".get_theme_mod( "tgimg-4")."'";} else {echo "src='//d33rxv6e3thba6.cloudfront.net/2016/11/581b45e2d93877bd681e08aa/28315-17lu7om.jpeg'";} ?>
 alt="3.jpeg" data-id="" title="3.jpeg" />
</span>
</div>
<div data-drag="P710" id="P710" class="simblaEL tcH">
<div data-border-type="All" data-group-id="e" id="irkz1i" class="textContainer H2">
<h2>
4 month plan</h2>
</div>
</div>
<div data-drag="P712" id="P712" class="simblaEL tcH">
<div data-border-type="All" data-group-id="f" id="ijja5l" class="textContainer H3">
<h3>
$80</h3>
</div>
</div>
<div data-drag="P720" id="P720" class="simblaEL tc">
<div data-border-type="All" data-group-id="gyyy" id="ibji3f" class="textContainer">
<p>
Want to add your own creative touch? Make your own theme! You have many tools to play around with, like colors schemes, icons, fonts, images, and backgrounds.
</p>
</div>
</div>
<button type="submit" data-drag="P716" id="P716" class="simblaEL btn">
Subscribe</button>
</div>
</div>
<div data-drag="P168" id="P168" class="simblaEL tcH">
</div>
<div data-drag="P182" id="P182" class="simblaEL tcH">
</div>
</div>
<div data-colsize="3" data-title="Column" class="sDivider col-md-3 index3">
<div data-drag="P682" id="P682" data-title="Row" data-border-type="All" data-group-id="tyty" class="row simblaEL rDivider">
<div data-colsize="12" data-title="Column" class="sDivider col-md-12 index0">
<div data-drag="P685" id="P685" class="simblaEL simblaImg">
<span id="tgimg-5">
<img <?php if( get_theme_mod( "tgimg-5") != "" ) {echo "src='".get_theme_mod( "tgimg-5")."'";} else {echo "src='//d33rxv6e3thba6.cloudfront.net/2016/11/581b45e2d93877bd681e08aa/28315-5vay1p.jpeg'";} ?>
 alt="4.jpeg" data-id="" title="4.jpeg" />
</span>
</div>
<div data-drag="P203" id="P203" class="simblaEL tcH">
<div data-border-type="All" data-group-id="e" id="i2ml874" class="textContainer H2">
<h2 id="i45kq2k">
Annual plan</h2>
</div>
</div>
<div data-drag="P204" id="P204" class="simblaEL tcH">
<div data-border-type="All" data-group-id="f" id="iuamcif" class="textContainer H3">
<h3 id="icw3aar">
$200</h3>
</div>
</div>
<div data-drag="P719" id="P719" class="simblaEL tc">
<div data-border-type="All" data-group-id="gyyy" id="io6k87h" class="textContainer">
<p id="io25kuz">
Want to add your own creative touch? Make your own theme! You have many tools to play around with, like colors schemes, icons, fonts, images, and backgrounds.
</p>
</div>
</div>
<div class="btn-wrap simblaEL">
<button type="submit" data-drag="P214" id="P214" class="simblaEL btn">
Subscribe</button>
</div>
</div>
</div>
<div data-drag="P186" id="P186" class="simblaEL tcH">
</div>
<div data-drag="P202" id="P202" class="simblaEL tcH">
</div>
</div>
</div>
</div>
</div>


		</main>
<!-- #main -->

	</div>
<!-- #primary -->

	<?php get_sidebar(); ?>

</div>
<!-- .wrap -->


<?php 
 $customfooter=0;
 foreach($todoslosthememods as $key =>
 $value)
	{
	   if(preg_match('/^nt_featured_Foopages/', $key))
	   {
		   if ($customfooter==0){
				$menunumber=str_replace("nt_featured_Foopages","",$key);			
				$idpageactual=$post->
ID;			
				if (in_array($idpageactual, $value)) { //Assigned to this page
					get_footer("custom$menunumber");
					$customfooter=1;
				}
				if (in_array("123454321", $value)) { //Assigned to all pages
					get_footer("custom$menunumber");
					$customfooter=1;
				}
				if (in_array("0", $value)) { //Assigned to no pages
					//get_footer("custom$menunumber");
					$customfooter=0;
				}
		   } 			
	   }
	}	
if ($customfooter==0) get_footer("");