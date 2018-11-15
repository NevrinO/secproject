 <?php
	class db {
        // The database connection
        protected static $connection;

        /**
         * Connect to the database
         * 
         * @return bool false on failure / mysqli MySQLi object instance on success
         */
        public function connect() {    
            // Try and connect to the database
            if(!isset(self::$connection)) {
                // Load configuration as an array. Use the actual location of your configuration file
                $config = parse_ini_file('login/config.ini'); 
                self::$connection = new mysqli($config['host'],$config['user'],$config['pass'],$config['name'],$config['port']);
            }

            // If connection was not successful, handle the error
            if(self::$connection === false) {
                // Handle error - notify administrator, log to a file, show an error screen, etc.
                return false;
            }
            return self::$connection;
        }

        /**
         * Query the database
         *
         * @param $query The query string
         * @return mixed The result of the mysqli::query() function
         */
        public function query($query) {
            // Connect to the database
            $connection = $this -> connect();

            // Query the database
            $result = $connection -> query($query);

            return $result;
        }

        /**
         * Fetch rows from the database (SELECT query)
         *
         * @param $query The query string
         * @return bool False on failure / array Database rows on success
         */
        public function select($query) {
            $rows = array();
            $result = $this -> query($query);
            if($result === false) {
                return false;
            }
            while ($row = $result -> fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }
		
		public function select_listing($id){
			$connection = $this -> connect();
			/* create a prepared statement */
			if ($stmt = $connection->prepare("SELECT * FROM listings WHERE listing_id=?")) {

				/* bind parameters for markers */
				$stmt->bind_param("i", $id);

				/* execute query */
				$stmt->execute();

				/* bind result variables */
				$result = $stmt->get_result();

				$stmt->close();
				return $result;
			}
		}
		
		public function verify_admin($user){
			$connection = $this -> connect();
			$result = false;
			/* create a prepared statement */
			if ($stmt = $connection->prepare("SELECT admin FROM accounts WHERE user=?")) {

				/* bind parameters for markers */
				$stmt->bind_param("s", $user);

				$stmt->execute();
				
				$stmt->bind_result($admin);
				
				$stmt->fetch();
				if($admin == 1){
					$result = true;
				}
				$stmt->close();
			}
			return $result;
		}
		
		public function select_user_listings($user){
			$connection = $this -> connect();
			/* create a prepared statement */
			if ($stmt = $connection->prepare("SELECT listing_id FROM listings WHERE user_name=?")) {

				/* bind parameters for markers */
				$stmt->bind_param("s", $user);

				/* execute query */
				$stmt->execute();

				/* bind result variables */
				$result = $stmt->get_result();

				$stmt->close();
				return $result;
			}
		}
		
		public function delete_listing($id, $user){
			$connection = $this -> connect();
			/* create a prepared statement */
			if ($stmt = $connection->prepare("DELETE FROM listings WHERE listing_id=? AND user_name=?")) {

				/* bind parameters for markers */
				$stmt->bind_param("is", $id, $user);

				/* execute query */
				if ( $stmt->execute() ) {
						$result = true;
				}
				else{
					$result = false;
				}
				$stmt->close();
				return $result;
			}
		}
		
		public function delete_user($user){
			$connection = $this -> connect();
			$result = false;
			/* create a prepared statement */
			if ($stmt = $connection->prepare("DELETE FROM accounts WHERE user=?")) {

				/* bind parameters for markers */
				$stmt->bind_param("s", $user);

				/* execute query */
				if ( $stmt->execute() ) {
					$result = true;
				}
				$stmt->close();
				return $result;
			}
		}
		
		public function delete_image($id, $listing_id, $name){
			$connection = $this -> connect();
			$file = 'upload_image/upload/'.$listing_id.'/'.$name;
			/* create a prepared statement */
			if ($stmt = $connection->prepare("DELETE FROM images WHERE img_id=? AND listing_id=?")) {

				/* bind parameters for markers */
				$stmt->bind_param("is", $id, $listing_id);

				/* execute query */
				if ( $stmt->execute() ) {
						unlink($file);
						$result = true;
				}
				else{
					$result = false;
				}
				$stmt->close();
				return $result;
			}
		}
		
		public function select_listings_images($id){
			$connection = $this -> connect();
			/* create a prepared statement */
			if ($stmt = $connection->prepare("SELECT * FROM images WHERE listing_id=?")) {

				/* bind parameters for markers */
				$stmt->bind_param("i", $id);

				/* execute query */
				$stmt->execute();

				/* bind result variables */
				$result = $stmt->get_result();

				$stmt->close();
				return $result;
			}
		}
		
		public function select_image($img_id, $id){
			$connection = $this -> connect();
			/* create a prepared statement */
			if ($stmt = $connection->prepare("SELECT * FROM images WHERE img_id=? AND listing_id=?")) {

				/* bind parameters for markers */
				$stmt->bind_param("ii", $img_id, $id);

				/* execute query */
				$stmt->execute();

				/* bind result variables */
				$result = $stmt->get_result();

				$stmt->close();
				return $result;
			}
		}
		
		public function insert_listing($user, $data){
			$connection = $this -> connect();
			/* create a prepared statement */
			if ($stmt = $connection->prepare('INSERT INTO listings (user_name, name, type, street, city, state, zip, price, description) VALUES(?,?,?,?,?,?,?,?,?)')) {

				/* bind parameters for markers */
				$stmt->bind_param("sssssssss", 
					$user,
					$data['name'], 
					$data['type'], 
					$data['street'],
					$data['city'],
					$data['state'],
					$data['zip'],
					$data['price'],
					$data['description']);

				/* execute query */
				if ($stmt->execute()) {
						$result = true;
				}
				else{
					$result = false;
				}
				$stmt->close();
				return $result;
			}			
		}
		
		public function insert_image($id, $img_name){
			$connection = $this -> connect();
			/* create a prepared statement */
			if ($stmt = $connection->prepare('INSERT INTO images (listing_id, img_name) VALUES(?,?)')) {

				/* bind parameters for markers */
				$stmt->bind_param("is", $id, $img_name);

				/* execute query */
				if ( $stmt->execute() ) {
						$result = true;
				}
				else{
					$result = false;
				}
				$stmt->close();
				return $result;
			}			
		}
		public function get_thumbnail($id){
			$connection = $this -> connect();
			/* create a prepared statement */
			if ($stmt = $connection->prepare("SELECT * FROM images WHERE listing_id=? AND thumbnail=1")) {

				/* bind parameters for markers */
				$stmt->bind_param("i", $id);

				/* execute query */
				$stmt->execute();

				/* bind result variables */
				$result = $stmt->get_result();

				$stmt->close();
				return $result;
			}
		}
		
		public function update_listing($id, $user, $data){
			$connection = $this -> connect();
			/* create a prepared statement */
			if ($stmt = $connection->prepare('update listings set name=?, type=?, street=?, city=?, state=?, zip=?, price=?, description=? where listing_id=? and user_name=?')) {

				/* bind parameters for markers */
				$stmt->bind_param("ssssssssis", 
					$data['name'], 
					$data['type'], 
					$data['street'],
					$data['city'],
					$data['state'],
					$data['zip'],
					$data['price'],
					$data['description'],
					$id, $user);

				/* execute query */
				if ( $stmt->execute() ) {
						$result = true;
				}
				else{
					$result = false;
					return $result;
				}
				$stmt->close();
				$stmt = $connection->prepare('update images set thumbnail=0 where listing_id=?');
				
				$stmt->bind_param("i", $id);

				/* execute query */
				if ( $stmt->execute() ) {
						$result = true;
				}
				else{
					$result = false;
					return $result;
				}
				$stmt->close();
				
				$stmt = $connection->prepare('update images set thumbnail=1 where listing_id=? and img_id=?');
				
				$stmt->bind_param("ii", $id, $data['img_id']);

				/* execute query */
				if ( $stmt->execute() ) {
						$result = true;
				}
				else{
					$result = false;
				}
				$stmt->close();
				return $result;
			}			
		}

        /**
         * Fetch the last error from the database
         * 
         * @return string Database error message
         */
        public function error() {
            $connection = $this -> connect();
            return $connection -> error;
        }

        /**
         * Quote and escape value for use in a database query
         *
         * @param string $value The value to be quoted and escaped
         * @return string The quoted and escaped string
         */
        public function quote($value) {
            $connection = $this -> connect();
            return "'" . $connection -> real_escape_string($value) . "'";
        }
		public function mysql_entities_fix_string($string){
			return htmlentities($this->mysql_fix_string($string));
		}
	
		private function mysql_fix_string($string){
			if(get_magic_quotes_gpc()) 
				$string = stripslashes($string);
			$connection = $this -> connect();
			return $connection->real_escape_string($string);
		}
    }
	?>