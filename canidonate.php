<!DOCTYPE html>
<html>
<head>
	<title>Can I Donate Blood?</title>
	<link rel="stylesheet" type="text/css" href="canidonate.css">
</head>
<body>
	<div class="container">
		<h2>Can I Donate Blood?</h2>
		<form id="blood-donation-form" onsubmit="return checkEligibility();">
			<div class="form-group">
				<label for="age">1. Are you between 18 and 65 years old?</label><br>
				<label><input type="radio" name="age" value="yes">Yes</label>
				<label><input type="radio" name="age" value="no">No</label>
			</div>
			<div class="form-group">
				<label for="weight">2. Do you weigh more than 50 kg (110 lbs)?</label><br>
				<label><input type="radio" name="weight" value="yes">Yes</label>
				<label><input type="radio" name="weight" value="no">No</label>
			</div>
			<div class="form-group">
				<label for="health">3. Are you in good health?</label><br>
				<label><input type="radio" name="health" value="yes">Yes</label>
				<label><input type="radio" name="health" value="no">No</label>
			</div>
			<div class="form-group">
				<label for="travel">4. Have you traveled outside of the country in the past 12 months?</label><br>
				<label><input type="radio" name="travel" value="yes">Yes</label>
				<label><input type="radio" name="travel" value="no">No</label>
			</div>
			<div class="form-group">
				<label for="tattoo">5. Have you gotten a tattoo or piercing in the past 12 months?</label><br>
				<label><input type="radio" name="tattoo" value="yes">Yes</label>
				<label><input type="radio" name="tattoo" value="no">No</label>
			</div>
			<div class="form-group">
				<label for="contact">6. Have you had close contact with someone who has hepatitis, HIV/AIDS or COVID-19?</label><br>
				<label><input type="radio" name="contact" value="yes">Yes</label>
				<label><input type="radio" name="contact" value="no">No</label>
			</div>
			<button type="submit">Check Eligibility</button>
		</form>
		<div id="result"></div>
	</div>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>
