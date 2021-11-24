<?php
	class RegistrationForm {
		protected $user;
		
		function generateForm(){
			?>
				<form class="col-12 col-md-6 col-xl-3" action="register.php" method="post">
					<div class="form-group">
						<label for="userName">Nazwa użytkownika:</label>
						<input class="form-control col-12" type="text" id="userName" name="userName" maxlength="25" />
					</div>
					<?php //Imię i nazwisko:<br/><input name="fullName" /><br/> ?>

					<div class="form-group">
						<label for="email">Email:</label>
						<input class="form-control col-12" type="email" name="email" id="email" />
					</div>

					<div class="form-group">
						<label for="password">Hasło:</label>
						<input class="form-control col-12" type="password" id="password" name="password" id="email" />
					</div>

					<div class="col-12 text-center"> 
						<input type="submit" name="submit" class="btn btn-dark btn-primary col-8" value="Zarejestruj" />
					</div>
				</form>
			<?php
		}

		function checkUser(){
			$args = array(
				'userName' => array( 'filter' => FILTER_VALIDATE_REGEXP,
									 'options' => array( 'regexp' => '/^[0-9A-Za-ząęłńśćźżó_-]{2,25}$/' )
							  ),
				/*'fullName' => array( 'filter' => FILTER_VALIDATE_REGEXP,
									 'options' => array( 'regexp' => '/^[A-Z]{1}[a-ząęłńśćźżó-]{1,25} [A-Z]{1}[a-ząęłńśćźżó-]{1,25}$/' )
							  ),*/
				'password' => array( 'filter' => FILTER_VALIDATE_REGEXP,
									 'options' => array( 'regexp' => "/.{8,25}/" )
							  ),
				'email' => FILTER_VALIDATE_EMAIL,
			);

			$data = filter_input_array(INPUT_POST, $args);
			
			$errors = "";
			foreach ($data as $key => $val) {
				if ($val === false or $val === NULL) {
					$errors .= $key . " ";
				}
			}
			
			if ($errors === "") {
				$this->user = new User($data['userName'], $data['email'],$data['password']);
			} else {
                throw new ErrorException('Hasło nie spełnia wymagań bezpieczeństwa');
				$this->user = NULL;
			}
			
			return $this->user;
		}
	}
?>