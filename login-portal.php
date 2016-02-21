<?php

class LoginPortal
{
	public $cookie;
	public $html;

	public $curl;
	private $url;

	public function __construct()
	{
		$this->curl = curl_init();
		$this->url = 'https://portal.usu.ac.id/login/proses_login.php';
		$this->html = null;
	}

	public function masuk($no_identitas, $password)
	{
		$post = ['username' => $no_identitas, 'password' => $password];
		$this->cookie = dirname(__FILE__) .  "/cookies/{$no_identitas}.txt";
		
		$this->password = $password;
		$this->no_identitas = $no_identitas;
	
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($this->curl, CURLOPT_POST, 1);
		curl_setopt($this->curl, CURLOPT_URL, $this->url);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($post));

		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
		
		$this->html = curl_exec($this->curl);

		return $this->login_sukses();
	}

	public function ambil_html_halaman()
	{
		return $this->html;
	}

	public function login_sukses()
	{
		$sukses = preg_match(
					'/[\w\W]+<h3>([\w .]+)<\/h3>[\s]+<h4>([\d]+)<\/h4>[\s]+<h4>([\w -.]+)<\/h4>[\s]+<\/div>/', 
					$this->ambil_html_halaman(),
					$this->cocok
				);

		if($sukses)
		{
			$this->nama = $this->cocok[0];
			$this->prodi = $this->cocok[1];
		}

		return $sukses;
	}

	public function __destruct() {}
	
	public function getKHSPage() {
		$this->curl = curl_init();
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($this->curl, CURLOPT_URL, "https://portal.usu.ac.id/informasi_hasil_studi/tampil.php");
		
		
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
		
		return curl_exec($this->curl);
	}
	
	public function getIPPage($token) {
		$post = ['btnSubmit' => 'Lihat', 'id' => '', 'page' => '', 'semester' => $token];
		
		$this->curl = curl_init();
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($this->curl, CURLOPT_URL, "https://portal.usu.ac.id/informasi_hasil_studi/tampil.php");
		curl_setopt($this->curl, CURLOPT_POST, 1);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($post));
		
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
		
		return curl_exec($this->curl);
	}
}