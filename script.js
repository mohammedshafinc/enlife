function checkEligibility() {
    // Get the values of the form inputs
    var age = document.querySelector('input[name="age"]:checked').value;
    var weight = document.querySelector('input[name="weight"]:checked').value;
    var health = document.querySelector('input[name="health"]:checked').value;
    var travel = document.querySelector('input[name="travel"]:checked').value;
    var tattoo = document.querySelector('input[name="tattoo"]:checked').value;
    var contact = document.querySelector('input[name="contact"]:checked').value;
  
    // Check if all questions have been answered
    if (age && weight && health && travel && tattoo && contact) {
      // Check eligibility based on the answers
      if (age === 'yes' && weight === 'yes' && health === 'yes' && travel === 'no' && tattoo === 'no' && contact === 'no') {
        // Redirect to register.php if eligible
        window.location.href = "register.php";
        alert("You are elgible to donate");
      } else {
        // Show not eligible message and redirect to index.php
        document.getElementById('result').innerHTML = 'You are not eligible to donate blood.';
        window.location.href = "index.php";
        alert("You are not elgible to donate");
      }
    } else {
      // Show incomplete message
      document.getElementById('result').innerHTML = 'Please answer all questions.';
    }
  
    // Prevent the form from submitting
    return false;
  }
  