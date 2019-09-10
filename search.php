<?php
include("config.php");
include("classes/SiteResultProvider.php");
include("classes/ImageResultProvider.php");

	if(isset($_GET["term"])){
	$term = $_GET["term"];
	}
	else{
		exit("the term is empty");
	}

	$type = isset($_GET['type']) ? $_GET['type'] : "sites";
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>welcome to Search</title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">		  	
	</script>
</head>
<body>

<div class="wrapper">
	
	<div class="header">
		
		<div class="headerContent">

			<div class="logoContainer">
				<a href="index.php">
				<img src="assets/css/images/search.png">
				</a>
			</div>

			<div class="searchContainer">
				<form action="search.php" method="GET">

					<div class="searchBarContainer">
						<input type="hidden" name="type" value="<?php echo $type ?>">
						<input class="searchBox" type="text" name="term" value="<?php echo $term; ?>">
						<button class="searchButton">
							<img src="assets/css/images/icons/search.png">
						</button>
					</div>

				</form>
			</div>

		</div>

		<div class="tabsContainer">
			<ul class="tabList">
				<li class='<?php echo $type == "sites" ? "active" : "" ?>'>
					<a href='<?php echo "search.php?term=$term&type=sites" ?>'>Sites</a>
					
				</li>
				<li class='<?php echo $type == "images" ? "active" : "" ?>'>
					<a href='<?php echo "search.php?term=$term&type=images" ?>'>Images</a>
					
				</li>
			</ul>
		</div>

	</div>
	<div class="mainResultsSection">
		<?php

		if($type == "sites"){
			$resultProvider = new SiteResultProvider($con);
			$pageSize = 15;

		}
		else {
			$resultProvider = new ImageResultProvider($con);
			$pageSize = 15;
		}

		
		$numResults = $resultProvider->getNumResult($term);

		echo "<p class='resultsCount'>$numResults results found </p>";

		echo $resultProvider->getResultsHtml($page,$pageSize,$term);
		?>
	</div>
	<div class="paginationContainer">
		
		<div class="pageButtons">
			
			<div class="pageNumberContainer">
				<img src="assets/css/images/s.png" />
			</div>
			<div class="pageNumberContainer">
				<img src="assets/css/images/e.png" />
			</div>
			
			<?php

				$pagesToShow = 10;
				$numPages = ceil($numResults / $pageSize);
				$pageLeft = min($pagesToShow, $numPages);
				$currentPage = $page - floor($pagesToShow /2);

				if($currentPage < 1 ){
					$currentPage = 1 ;
				}

				if($currentPage + $pageLeft > $numPages +1){
					$currentPage = $numPages +1  - $pageLeft;
			}

				while($pageLeft != 0 && $currentPage <= $numPages){

				if($currentPage == $page){
					echo "<div class='pageNumberContainer'>
						<img src='assets/css/images/a_red.png'>
						<span class='pageNumber'>$currentPage</span>

					</div>";
				}else {
					echo "<div class='pageNumberContainer'>
						<a href='search.php?term=$term&type=$type&page=$currentPage'>
						<img src='assets/css/images/a_yellow.png'>
						<span class='pageNumber'>$currentPage</span>
						</a>
					</div>";
			}
					$currentPage++;
					$pageLeft--;
			}

			?>
			<div class="pageNumberContainer">
				<img src="assets/css/images/r.png" />
			</div>
			<div class="pageNumberContainer">
				<img src="assets/css/images/c.png" />
			</div>
			<div class="pageNumberContainer">
				<img src="assets/css/images/h.png" />
			</div>

		</div>	
		
	</div>
</div>
	
	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
	<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
	<script type="text/javascript" src="assets/js/script.js"></script>

</body>
</html>