<!-- FORM -->
<?php
//###############################################################################################
	// EMPTY VARIABLES
	$firstname = $lastname = $gender = $country = $email = $message = "";	
	$firstname_err = $lastname_err = $gender_err = $country_err = $email_err = $message_err = "";
	



//###############################################################################################

	if ($_SERVER['REQUEST_METHOD']=="POST"){

	// FIRSTNAME VARIABLE
	if(empty(trim($_POST['firstname']) )){
		$firstname_err = "❌ Firstname is empty";
	} else {
		$firstname = sanitizeNames($_POST['firstname']);
		if ($firstname == FALSE){
			$firstname_err = "🚫 Firstname is not valid";
		}
	}

	// LASTNAME VARIABLE
	if(empty(trim($_POST['lastname']) )){
		$lastname_err = "❌ Lastname is empty ";
	} else {
		$lastname = sanitizeNames($_POST['lastname']);
		if ($lastname == FALSE){
			$lastname_err = "🚫 Lastname is not valid";
		}
	}

	// GENDER VARIABLE
	if (empty($_POST['gender'])){
		$gender_err = "❌ Gender is empty ";
	} else {
		$gender = htmlspecialchars(strip_tags($_POST['gender']));
	}

	// EMAIL VARIABLE
	if(empty(trim($_POST['email']) )){
		$email_err = "❌ Email adress is empty";
	} else {
		$email = sanitizeEmail($_POST['email']);
		if ($email == FALSE){
			$email_err = "🚫 Email adress is not valid";
		}
	}

	// COUNTRY VARIABLE
	if($country == 0){
		$country_err = "❌ You haven't selected your country";
	} else {
		$country = htmlspecialchars(strip_tags($_POST['countries']));
	}

	// MESSAGE VARIABLE
	if(empty(trim($_POST['message']) )){
		$message_err = "❌ Your message is empty";
	} else {
		$message = sanitizeNames($_POST['message']);
		if ($message == FALSE){
			$message_err = "🚫 Your message is not valid";
		}
	}

}
//###############################################################################################

// FUNCTIONS
function forceReset() {
	$firstname = $lastname = $gender = $country = $email = $message = "";
} 

function sanitizeNames($field){
	$field = ctype_alpha(filter_var(trim($field), FILTER_SANITIZE_STRING));
    
    if(filter_var($field, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        return $field;
    } else{
        return FALSE;
    }
}

function sanitizeEmail($field){
    $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);
    if(filter_var($field, FILTER_VALIDATE_EMAIL)){
        return $field;
    } else{
        return FALSE;
    }
}
    
//###############################################################################################
?>

<html>

<div class="container">
	<div class="row">
		<div class="form rounded-lg col-10 offset-1">

			<div class="row">
				<div class="col-12 form-group">
					<u><h2>Contact form:</h2></u>
				</div>
			</div>

			<form method="post" action="index.php" autocomplete="on" id="form">

			<!-- [1] ROW -->
			<div class="row">
				<div class="firstname col-md-6 col-12">
					<!-- 💬 Firstname -->
					<label for="formFirstname">Firstname:</label>
					<input  class="form-control" type="text" size="20" name="firstname" id="formFirstname" alt="Your firstname input"  placeholder="Your Firstname" value=<?php echo "$firstname"?> >
					<span class="error"><?php echo $firstname_err;?></span>
				</div>

				<div class="lastname col-md-6 col-12">
					<!-- 💬 Lastname -->
					<label for="formLastname">Lastname:</label>
					<input  class="form-control" type="text" size="20" name="lastname" id="formLastname" value="<?php echo $lastname ?>" placeholder="Your Lastname"   alt="Your lastname input"/>
					<span class="error"><?php echo $lastname_err;?></span>
				</div>
			</div>
			
			<!-- [2] ROW -->
			<div class="row">
				<div class="gender col-md-6 col-12">
					<!-- 🚻 Gender -->
					<p>Choose your gender:<br>
					<span class="error"><?php echo $gender_err;?></span>
					</div>
					<div class="gender col-md-3 col-12">	
						<label for="male">Male</label>
						<input  type="radio" name="gender" id="male" value="Male"   alt="Choose that if you are a man"> 
					</div>		
					<div class="gender col-md-3 col-12">				
						<label for="female">Female</label>
						<input type="radio" name="gender" id="female" value="Female"   alt="Choose that if you are a woman"> </p>
					</div>	
				
			</div>

			<!-- [3] ROW -->
			<div class="row">
				<div class="email col-md-6 col-12">
					<!-- 💬 Email -->
					<label for="formEmail">E-mail:</label>
					<input  class="form-control" type="text" name="email" id="formEmail" placeholder="email@example.com" value="<?php echo $email ?>"   alt="Your email input"/>
					<span class="error"><?php echo $email_err;?></span>
				</div>

				<div class="country col-md-6 col-12 ">	
					<!-- ✳️ Country -->
					<fieldset>
						<label>Country:</label>
							<select name="countries" class="form-control">
								<?php
									include 'countries.php';
								?>
							</select>
					</fieldset>
					<span class="error"><?php echo $country_err;?></span>
				</div>
			</div>

			<!-- [4] ROW -->
			<div class="row">
				<div class="subject col-md-6 col-12">	
					<!-- ✳️ Subject selection -->
						<fieldset >
							<label>Select your subject:</label>
								<select name="subjects" class="form-control">
									<?php
									$subjects = array('OTR'=>'Others','HLP'=>'Help','CPL'=>'Complain');
										foreach ($subjects as $key => $element) {
											echo "<option value='$key'>$element</option>";
											$i++;
											}
									?>
								</select>
						</fieldset>
				</div>
			</div>

			<!-- [5] ROW -->
			<div class="row">
				<div class="message col-md-6 col-12 d-flex justify-content-center">	
					<div class="textaMessage ">
						<!-- Message text area -->
						<label for="formMessage">Please, feel free to write us. We recommend using keywords to help our team be as efficient as possible. You'll receive an answer within 5 days. Thank you for your trust.</label><br>
					</div>
				</div>

				<div class="message col-md-6 col-12 d-flex justify-content-center">
					<div class="textareaBox">
						<!-- 💬 Message Box area -->
						<textarea  class="form-control" placeholder="Write your text here..." name="message" cols="28" rows="6" id="formMessage"   alt="Enter your text here"><?php if (isset($message))echo "$message";?></textarea>
						<span class="error"><?php if (isset($message_err))echo "$message_err";?></span>
					</div>
				</div>
			</div>

			<!-- [6] ROW -->
			<div class="row">
				<div class="col-md-6 d-flex justify-content-center">	
					<!-- Reset button -->
					<input class="btn btn-primary" type="reset" value="RESET" onclick="forceReset();">
				</div>

				<div class="col-md-6 d-flex justify-content-center">	
					<!-- Submit button -->
					<input class="btn btn-primary" type="submit" value="SUBMIT">
				</div>
			</div>
			
			</form>
		</div>
	</div>
</div>

<?php
		// 😁 Because <BR> is life 😁
		echo "###############################################################";
		echo "<br>";
		echo "<h2>Your Given details:</h2>";
		echo "<br>";
		echo "#############################";
		echo "<br>";
		echo "<br>";
		echo "💩💩💩";
		print_r($_POST);
		echo "<br>";
		echo "<br>";
		echo "###############################################################";
?>


</html>