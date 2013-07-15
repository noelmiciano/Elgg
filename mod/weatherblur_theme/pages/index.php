<?php
	// Load Elgg engine
	include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php";
	
	
	$body = elgg_view('index.php');
	$content = '<div class="wb-body">

	<!-----------------------------------------------
				DATA COLLECTION
	------------------------------------------------->
	<div class="green-bkgd">
		<div class="map_dct_container">
			<div id="data_collection">
				<h2>Enter Data</h2>
			</div><!--End data collection-->			
			<div id="homepage_map">
				<h2>Explore Data</h2>
			</div><!--End homepage map-->		
		</div><!--End map_dct_container-->
	</div><!--End green-bkgd-->
	
	<!-----------------------------------------------
				FEATURED 3 COLUMNS
	------------------------------------------------->
	<div class="featured-three-columns">
		<div id="three-columns-content">
		
			<div id="latest-news">
				<h2>Latest News</h2>
				<div id="latest-news-photo"></div>
				<h3><a class="featured-title" href="#">Title goes here</a></h3>
				<p class="description">Description goes here. Description goes here. Description goes here. Description goes here. Description goes here. Description goes here. Description goes here. Description goes here.</p>
				<a class="orange-links" href="#">View more news</a>
			</div><!-- End lastest news-->
			
			<div id="featured-investigation">
				<h2>Featured Investigation</h2>
				<div id="notebook-background">
					<div id="featured-investigation-photo"></div>
				</div><!--End notebook background-->
				<h3><a class="featured-title" href="#">Title goes here</a></h3>
				<p class="description">Description goes here. Description goes here. Description goes here. Description goes here. Description goes here. Description goes here. Description goes here. Description goes here.</p>
				<a class="orange-links" href="#">View more investigations</a>
			</div><!-- End featured investigation-->
			
			<div id="activity">
				<h2>Activity</h2>
					<div id="activity-block">
						<div id="noel" class="avatar"></div>
						<h3 class ="username">Noel Miciano</h3>
						<h4 class="post-date">Posted on 12/15/2012</h4>
						<p class="activity-description">Description goes here. Description goes here. Description goes here. Description goes here.</p>
					</div><!--End activity block-->
						
					<div id="activity-block">
						<div id="scott" class="avatar"></div>
						<h3 class ="username">Scott Stewart</h3>
						<h4 class="post-date">Posted on 12/15/2012</h4>
						<p class="activity-description">Description goes here. Description goes here. Description goes here. Description goes here.</p>
					</div><!--End activity block-->
						
					<div id="activity-block">
						<div id="steph" class="avatar"></div>
						<h3 class ="username">Stephanie Caggiano</h3>
						<h4 class="post-date">Posted on 12/15/2012</h4>
						<p class="activity-description">Description goes here. Description goes here. Description goes here. Description goes here.</p>
					</div><!--End activity block-->	
					
						<a class="orange-links" href="#">View more activity</a>
			</div><!-- End activity-->
			
			<!-----------------------------------------------
							FEATURED BLOCK
			------------------------------------------------->
			<div id="featured-block">
				<div id="left-dashes" class="dashed-box"></div>
				<h2>Featured</h2>
				<div id="right-dashes" class="dashed-box"></div>
				<div id="featured-school">
					<a class="featured-pic" href="#"></a>
					<a class="featured-category" href="#">Featured School</a>
					<a class="featured-name" href="#">Name goes here</a>
				</div><!--End featured school-->
						
				<div id="featured-fisherman">
					<a class="featured-pic" href="#"></a>
					<a class="featured-category" href="#">Featured Fisherman</a>
					<a class="featured-name" href="#">Name goes here</a>
				</div><!--End featured fisherman-->
						
				<div id="featured-scientist">
					<a class="featured-pic" href="#"></a>
					<a class="featured-category" href="#">Featured Scientist</a>
					<a class="featured-name" href="#">Name goes here</a>
				</div><!--End featured scientist-->
			</div><!--End featured block-->

		</div><!-- End three columns content-->
	</div><!-- End featured three columns-->
</div><!--End wb body-->';
		
			$canvas_area = elgg_view_layout('default', array('content' => $content));
			echo elgg_view_page($title, $canvas_area);

		?>


