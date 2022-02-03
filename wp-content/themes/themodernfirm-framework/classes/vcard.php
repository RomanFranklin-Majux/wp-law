<?php

class TMF_Vcard {

	protected $_data = array();


	public static function actions () {
		add_action('wp', array('TMF_Vcard', 'check_for_vcard_request'));
	}


	public function __construct( array $data = NULL) {
		if ($data !== NULL):
			$this->_data = $data + $this->_data;
		endif;
	}


	public function & __get($key) {
		return $this->_data[$key];
	}


	public function __set($key, $value) {
		$this->set($key, $value);
	}


	public function __isset($key) {
		return isset($this->_data[$key]);
	}


	public function __unset($key) {
		unset($this->_data[$key]);
	}


	public function set($key, $value = NULL) {
		if (is_array($key)):

			foreach ($key as $name => $value):
				$this->_data[$name] = $value;
			endforeach;

		else:
			$this->_data[$key] = $value;
		endif;

		return $this;
	}


	public static function check_for_vcard_request () {
		global $wp_option, $post;

		if (isset($_GET['vcard'])):

			$vcard					= new TMF_Vcard;
			$vcard->url				= SITE_URL;
			$vcard->name			= $post->tmf->person_name;
			$vcard->nname 			= $post->tmf->last_name.';'.$post->tmf->first_name;

			if (isset($wp_option->blogname))
				$vcard->company		= str_replace(array('&amp;', '&'), 'and', $wp_option->blogname);

			if (isset($post->_email))
				$vcard->email		= $post->_email;

			if (isset($post->_phone_1))
				$vcard->phone_1		= $post->_phone_1;

			if (isset($post->_phone_2))
				$vcard->phone_2		= $post->_phone_2;

			if (isset($post->_fax))
				$vcard->fax			= $post->_fax;

			if (isset($post->_avvo))
				$vcard->avvo		= $post->_avvo;

			if (isset($post->_linkedin))
				$vcard->linkedin	= $post->_linkedin;

			if (isset($post->_twitter))
				$vcard->twitter		= $post->_twitter;

			if (isset($post->_google))
				$vcard->google_plus	= $post->_google;

			// Location
			if (isset($post->_primary_location)):
				if ($location = get_post($post->_primary_location)):

					if (isset($location->_address_1))
						$vcard->address	= $location->_address_1;

					if (isset($location->_address_2))
						$vcard->address	.= ' ' . $location->_address_2;

					if (isset($location->_city))
						$vcard->city	= $location->_city;

					if (isset($location->_state))
						$vcard->state	= $location->_state;

					if (isset($location->_zipcode))
						$vcard->zipcode	= $location->_zipcode;

					if (isset($location->_country))
						$vcard->country	= $location->_country;
				endif;
			endif;
			
			$vcard->download();

			exit;
		endif;
	}




	private function build() {


		$this->card  = "BEGIN:VCARD\r\n";
		$this->card .= "VERSION:2.1\r\n";
		$this->card .= "FN:" . $this->name . "\r\n";
		$this->card .= "N:" . $this->nname . "\r\n";

		if ($this->company)
			$this->card .= "ORG:" . $this->company . "\r\n";

		if ($this->title)
			$this->card .= "TITLE:" . $this->title . "\r\n";

		if ($this->address)
			$this->card .= "ADR;WORK:;;" . $this->address . ";" . $this->city . ";" . $this->state . ";" . $this->zipcode . ";" . $this->country . "\r\n";

		if ($this->email)
			$this->card .= "EMAIL;PREF;INTERNET:" . $this->email . "\r\n";

		if ($this->phone_1)
			$this->card .= "TEL;PREF;WORK;VOICE:" . $this->phone_1 . "\r\n";

		if ($this->phone_2)
			$this->card .= "TEL;WORK;VOICE:" . $this->phone_2 . "\r\n";

		if ($this->fax)
			$this->card .= "TEL;WORK;FAX:" . $this->fax . "\r\n";

		if ($this->url)
			$this->card .= "URL;WORK:" . $this->url . "\r\n";

		if ($this->avvo)
			$this->card .= "URL;WORK:" . $this->avvo . "\r\n";

		if ($this->linkedin)
			$this->card .= "URL;WORK:" . $this->linkedin . "\r\n";

		if ($this->twitter)
			$this->card .= "URL;WORK:" . $this->twitter . "\r\n";

		if ($this->google_plus)
			$this->card .= "URL;WORK:" . $this->google_plus . "\r\n";

		$this->card .= "END:VCARD\r\n";
	}
  

	public function download() {

		$this->build();

		if (!$this->filename)
			$this->filename = trim($this->name);

		$this->filename = strtolower(preg_replace("/[^ \w]+/", "", str_replace(" ", "_", $this->filename)));

		header("Content-type: text/vcard");
		header("Content-Disposition: attachment; filename=" . $this->filename . ".vcf");
		header("Pragma: public");

		echo $this->card;
		exit;
	}
}