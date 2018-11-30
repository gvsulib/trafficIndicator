<?
date_default_timezone_set ( "America/Detroit" );


$raw = file_get_contents('https://prod.library.gvsu.edu/trafficapi/traffic');
$labels = json_decode($raw, TRUE);

$entriesJSON = file_get_contents('https://prod.library.gvsu.edu/trafficapi/entries');
$entries = json_decode($entriesJSON, TRUE);


//the first entry should be the most recent
$entrynum = $entries[0]["entryID"];

$timestamp = $entries[0]["time"];

$unixTimeStamp = strtotime($timestamp);

$timeString = date("l, F d Y g:i A", $unixTimeStamp);

//get rid of the huge list of entries, we don't need it anymore and we don't want it cluttering up memory
unset($entriesJSON);

unset($entries);

$trafficData = file_get_contents("https://prod.library.gvsu.edu/trafficapi/entries/$entrynum/traffic");

$trafficArray = json_decode($trafficData, TRUE);

$checkedArray = array();

//get all the traffic levels except -1, which is an event
foreach ($trafficArray as $entry) {

    if ($entry["level"] != "-1") {
        $checkedArray[] = (int) $entry["level"];
    }


}
//now calculate the average and round it up

$average = round(array_sum($checkedArray)/count($checkedArray), 0, PHP_ROUND_HALF_UP);




foreach ($labels as $label) {
    if ((int) $label["ID"] == $average) {
        $trafficLabel = $label["name"];
    }
}

switch ($average) {
	case 1:
		$style = "green";
		break;
	case 2:
		$style = "yellow";
		break;
	case 3:
		$style = "orange";
		break;
	case 4:
		$style = "red";
		break;


}




?>
<!DOCTYPE html>
<html><head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="UTF-8">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="pragma" content="no-cache">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		GVSU University Libraries - Book a Consultation
	</title>
	
	<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=EB+Garamond|Lato:400,700">
	<link type="text/css" rel="stylesheet" href="https://prod.library.gvsu.edu/libs/fontawesome/fontawesome-all.min.css">
	<link type="text/css" rel="stylesheet" href="https://gvsu.edu/cms4/skeleton//1/files/css/styles.css">
	<link type="text/css" rel="stylesheet" href="https://gvsu.edu/library/files/css/base.css">
	<script src="https://gvsu.edu/cms4/skeleton/1/files/js/cms4.1.min.js"></script>
	<script src="https://prod.library.gvsu.edu/labs/template_hours/hours.js"></script>


	<style>
	.green {
    background: #6c6;
    
	}

	.yellow {
		background: #f7ec1e;
		
	}	

	.orange {
		background: #ff9400;
		
	}

	.red {
		background: #c00;
	}

	</style>

	
</head>

<body>

	<div role="banner">
			<a href="#main" class="focus-inverted">Skip to main content</a>
			
			
			<div class="header">
				<div class="row content">
					<div class="col-5 col-sm-12 logo">
						<div class="col-12 col-sm-9">
							<h1>
								<a href="https://www.gvsu.edu">
									<!--[if lte IE 8|!IE]>
										<img src="/homepage/files/img/gvsu_logo_white.png" alt="Grand Valley State University Logo" />
									<![endif]-->
									<!--[if gte IE 9|!IE]><!-->
										<img src="https://gvsu.edu/homepage/files/img/gvsu_logo_white.svg" alt="Grand Valley State University Logo" onerror="this.onerror=null;this.src='https://gvsu.edu/homepage/files/img/gvsu_logo_white.png'">
									<!--<![endif]-->
									<span id="gv-logo-label" class="sr-only" aria-hidden="true">Grand Valley State University</span>
								</a>
							</h1>
						</div>
						<div class="hide-lg hide-md col-sm-3">
							<a id="gv-hamburger" role="button" tabindex="0" aria-label="Menu" aria-controls="cms-navigation-mobile">
								<img src="https://prod.library.gvsu.edu/labs/cms4.1_files/menu.png" alt="" style="width:auto;min-width:auto;" aria-hidden="true"></span>
							</a>
						</div>
					</div>
					<div class="col-7 col-sm-12 quick hide-print hide-sm">
						
					</div>
				</div>
			</div>
			<div class="site">
				<div class="row content">
					<div class="col-8 col-sm-12">
						<h1 class="h2 serif padding-none">
							<a href="https://gvsu.edu/library">
								University Libraries
							</a>
						</h1>
						<h2 class="sr-only">Search</h2>
						<form action="https://gvsu.summon.serialssolutions.com/search" class="library-search" role="search">
							<input name="spellcheck" value="true" type="hidden">
							<p>
								<label for="s.q" class="sr-only">
									Search the Library for Articles, Books, and More
								</label>
								<input id="s.q" name="s.q" placeholder="Find articles, books, &amp; more" size="45" type="text"><button type="submit">Find It!</button>
							</p>
						</form>
						<div class="library-nav">
							<h3>More research tools:</h3>
							<ul>
								<li>
									<a href="https://libguides.gvsu.edu/az.php">Databases</a>
								</li>
								<li>
									<a href="https://gvsu.edu/library/findbooks">Books</a>
								</li>
								<li>
									<a href="https://gvsu.edu/library/findjournals">Journals</a>
								</li>
								<li>
									<a href="https://libguides.gvsu.edu/">Subject Guides</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-4 col-sm-12 library-hours">
							
					</div>
				</div>
			</div>
			
				<div id="cms-navigation" class="navigation hide-sm hide-print">
					<div class="content">
						<div role="navigation">
	<ul role="menubar">
		
					<li>
						<a href="https://gvsu.edu/library/find-materials-2.htm" target="_self">
							Find Materials
						</a>
					</li>
				
					<li>
						<a href="https://gvsu.edu/library/services-4.htm" target="_self">
							Services
						</a>
					</li>
				
					<li>
						<a href="hhttps://gvsu.edu/library/about-the-university-libraries-3.htm" target="_self">
							About Us
						</a>
					</li>
				
					<li>
						<a href="https://help.library.gvsu.edu" target="_self">
							Help
						</a>
					</li>
				
					<li>
						<a href="https://www.gvsu.edu/library/myaccount" target="_self">
							My Account
						</a>
					</li>
				
	</ul>
</div>
					</div>
				</div>
			
		</div>




<div role="main" id="main">
	<div class="content">
		
			<div id="cms-content">


			<h1>How Busy is the Mary Idema Pew Library Right Now?</h1>

			<P> As of <? echo $timeString; ?></P>


<div id="trafficLevel" style="text-align: center; width: 150px">
 <div class="<? echo $style; ?>" style="width: 150px; height: 100px"></div><P>
<b><? echo $trafficLabel; ?></b>
</P>
</div>


<P>This data is collected approximately every hour. </P>

<P>Kirkhof Center will also be reserving space for extra student study and the Loutit atrium will have extra study tables. Text the library at 616-818-0219 for customized seating suggestions.</P>

</div>
    </div>
            </div>

<div class="clear hide-sm"></div>
					<div class="hide-print">
				<br>
				<hr>
				
			<div class="row">
				<div class="col-6">
					
						
				</div>
				<div class="col-6 text-right">
					
						<a href="https://prod.library.gvsu.edu/status/?problem" class="cms-report-problem">Report a problem with this page</a>
					
				</div>
			</div>
		
			</div>
							<script>
								var thisUrl = encodeURI(window.location);
								document.getElementById('problem-link').href = 'https://prod.library.gvsu.edu/status/?problem&url=' + thisUrl;
							</script> 

			</div>
	</div>
</div>

	<div role="contentinfo">
			
				<div class="footer hide-print">
					<div class="content">
						<h1 class="sr-only">Footer</h1>
						<div class="row-gutter">
							
								<div class="col-3 col-md-4 col-sm-6">
									<h2 class="padding-none color-white">
										Contact
									</h2>
									
											<p class="vcard">
												
														<span class="tel">
															<span class="value">
																<a href="tel:616-331-3500">(616) 331-3500</a>
															</span>
															
														</span>
														<br>
													
														<a href="mailto:library@gvsu.edu" class="email">library@gvsu.edu</a>
														<br>
													
											</p>
											
												<br>
											
											<p class="vcard">
												
														<span class="fn">Text Us!</span>
														<br>
													
														<span class="tel">
															<span class="value">
																<a href="sms:616-818-0219">(616) 818-0219</a>
															</span>
															
														</span>
														<br>
													
											</p>
											
								</div>
							
								<div class="col-3 col-md-4 col-sm-6">
									<h2 class="padding-none color-white">
										Social Media
									</h2>
									
											<p>
												
													<a href="https://twitter.com/gvsulib" title="Twitter" class="text-nodecoration" target="_blank">
														<img src="https://prod.library.gvsu.edu/labs/cms4.1_files/twitter.png" alt="" style="width:auto;min-width:auto;" />
														<span class="sr-only">https://twitter.com/gvsulib</span>
													</a>
												
													<a href="https://youtube.com/user/gvsulib" title="YouTube" class="text-nodecoration" target="_blank">
														<img src="https://prod.library.gvsu.edu/labs/cms4.1_files/youtube.png" alt="" style="width:auto;min-width:auto;" />
														<span class="sr-only">https://youtube.com/user/gvsulib</span>
													</a>
												
													<a href="https://instagram.com/gvsulib" title="Instagram" class="text-nodecoration" target="_blank">
														<img src="https://prod.library.gvsu.edu/labs/cms4.1_files/instagram.png" alt="" style="width:auto;min-width:auto;" />
														<span class="sr-only">https://instagram.com/gvsulib</span>
													</a>
												
											</p>
											
										<br class="hide-lg hide-md">
									
								</div>
							
							<div class="col-3 col-md-4 col-sm-6">
								<h2 class="padding-none color-white">
									Committed to Equality
								</h2>
								<a href="https://gvsu.edu/library/acrl" target="_blank">
									<img src="https://www.gvsu.edu/cms4/asset/0862059E-9024-5893-1B5AAAC2F83BDDD8/acrl.png" alt="ACRL Diversity Alliance Logo" style="width:auto;max-width:100%;">
								</a>
							</div>
							<div class="col-3 col-md-4 col-sm-6">
								<h2 class="padding-none color-white">
									Federal Depository Library Program
								</h2>
								<a href="https://gvsu.edu/library/govdoc" target="_blank">
									<img src="https://www.gvsu.edu/cms4/asset/0862059E-9024-5893-1B5AAAC2F83BDDD8/fdlp-new.png" alt="Federal Depository Library Program Logo" style="width:auto;max-width:100%;">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="bottom hide-print">
		<div class="content">
			<div class="row-gutter">
				<div class="col-12 legal">
					<h2 class="sr-only">Legal</h2>
					<ul>
						<li>
							<a href="https://gvsu.edu/affirmativeactionstatement.htm"><span class="hide-sm hide-md">GVSU is an </span>AA/EO Institution</a>
						</li>
						<li>
							<a href="https://gvsu.edu/privacystatement.htm">Privacy Policy</a>
						</li>
						<li>
							<a href="https://gvsu.edu/disclosures">Disclosures</a>
						</li>
						<li>
							<span class="hide-sm hide-md">Copyright </span>© 2018 GVSU
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://prod.library.gvsu.edu/labs/chatbutton/chatbutton.js"></script>

</body>
</html>