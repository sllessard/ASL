<!Doctype html>
<html lang="en">
<head>
	<?php
	include 'includes/head.php'; 
	?>
	<title>a / s / l ???</title>
</head>
<body>
	<main>
		<header>
			<h1>a / s / l ???</h1>
			<?PHP 
			include 'includes/header.php'; 
			?>
			<div id="errorMessage">
				<p>€ЯЯƟƦ</p>
				<ul>
					<li>ƷʶʶǾΓ</li>
					<ul>
						<li>ΣԄԄѺṜ</li>
					</ul>
				</ul>
				<p>Oh no!!!</p>
				<ul>
					<li>Ξ╔╔۝ʁ</li>
					<ul>
						<li>ҼԈԈФⱤ</li>	
					</ul>
				</ul>
				<p id="errorType"></p>
			</div>
			<?php
			session_start();
			if ($_SESSION['fieldscomplete'] === false) { //PHP fallback if JavaScript form verification fails.
				echo('
					<div id="phpErrorMessage" style="display: block;">
					<p>€ЯЯƟƦ</p>
					<ul>
					<li>ƷʶʶǾΓ</li>
					<ul>
					<li>ΣԄԄѺṜ</li>
					</ul>
					</ul>
					<p>Oh no!!!</p>
					<ul>
					<li>Ξ╔╔۝ʁ</li>
					<ul>
					<li>ҼԈԈФⱤ</li>	
					</ul>
					</ul>
					<p>Complete all fields!!!</p>
					</div>
					');
				} ?>
			</header>
			<form class="inputOutput" name="aslForm" action="includes/entry.php" method="post" onsubmit="return validate()">
				<div class="verticalDividers">
					<div class="selectBox">
						<label for="age" id="agelabel">a</label>
						<div class="selectIcon">
							<select name="ageSelect" id="age" aria-labelledby="agelabel" aria-required="true" onchange="form_ready()">
								<option value="" selected disabled></option>
								<?php
								for ($i=1; $i<=122; $i++) { //Build input options for age.
									?>
									<option value="<?php echo $i;?>">
										<?php echo $i;?>
									</option>
									<?php
								}
								?>			
							</select>
						</div>
					</div>
					<div class="selectBox">
						<label for="sex" id="sexlabel">s</label>
						<div class="selectIcon">
							<select name="sexSelect" id="sex" aria-labelledby="sexlabel" aria-required="true" onchange="form_ready()">
								<option value="" selected disabled></option>
								<option value="F">F</option>
								<option value="I">I</option>
								<option value="M">M</option>
							</select>
						</div>
					</div>
				</div>
				<div class="textEntry">
					<label for="location" id="locationlabel">l</label>
					<textarea name="locationEntry" autocomplete="on" maxlength="500" id="location" aria-labelledby="locationlabel" aria-required="true" onkeyup="form_ready()"></textarea>
				</div>
				<button type="submit" value="insert" id="submitButton">
					<div id="gradientAnimator"></div>
					<span class="rotate" id="face">&#9787;&#xFE0E;</span>
				</button>
			</form>
		</main>
		<script>
			'use strict';

			var $ageInput = document.forms.aslForm.ageSelect,
			$sexInput = document.forms.aslForm.sexSelect,
			$locationInput = document.forms.aslForm.locationEntry,
			$errorMessage = document.getElementById("errorMessage");

				document.getElementById("face").style.transform = "rotate(180deg)"; //Rotate face if JS enabled

				function form_ready() { //On select change or textarea key up check if all fields have value.
					var a = $ageInput.value,
					s = $sexInput.value,
					l = $locationInput.value.trim();

					if ($errorMessage.style.display === "block") { //Remove error message if visible
						$errorMessage.style.display = "none";
					}


					if ( a && s && l) { //Rotate face and animate gradient
						document.getElementById("face").style.transform = "rotate(0deg)";
						document.getElementById("gradientAnimator").style.height="200%";
					} else {
						document.getElementById("face").style.transform = "rotate(180deg)";
						document.getElementById("gradientAnimator").style.height="100%";
					}
				}

				function validate(){ //On form submit verify all fields are non-empty

					var a = $ageInput.value,
					s = $sexInput.value,
					l = $locationInput.value.trim();

					if (!a) { //Return empty field required for submit
						return errorMessage("age");
					}
					else if (!s) {
						return errorMessage("sex");
					}
					else if (!l) {
						return errorMessage("location");
					} else {
						return true; //Form submits
					}

					function errorMessage(error) {

						if (document.getElementById("phpErrorMessage")) { //Remove PHP error message if displayed
							document.getElementById("phpErrorMessage").style.display = "none";
						}
						
						document.getElementById("errorType").innerHTML="Enter your " + error + " !!!"; //Display JS error message for empty inputs
						$errorMessage.style.display = "block";
						return false; //Do not submit form
					}
				}
			</script>
		</body>
		</html>