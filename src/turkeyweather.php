
<?php
/* amacınız kütüphaneyi geliştirmek değil sadece kullanmaksa bu sayfada herhangi bir değişiklik yapmanıza gerek yok. */

class TurkeyWeather{
	// sadece degişkenleri tanımlar. herhangi bir değer vermeye gerek yok
	private $province_name = ""; 
	private $district_name = "";
	private $targetLocationDetails = ""; 
	private $weatherDetails = "";

	function __construct($p = null, $d = null) {
		$this->province_name = $p;
		$this->district_name = $d;
		if($this->province_name!=null){
			$this->getData();
		}
	}

	private function getData(){ // Bilgileri mgm.gov.tr den getirir

		// türkçe karakterleri her ihtimale karşı değiştiriyor
		$province = str_replace(['Ç','ç','ı','İ','Ğ','ğ','Ö','ö','Ü','ü','ş','Ş','â','Â'], ['c','c','i','i','g','g','o','o','u','u','s','s','a','a'], $this->province_name);
		$district = str_replace(['Ç','ç','ı','İ','Ğ','ğ','Ö','ö','Ü','ü','ş','Ş','â','Â'], ['c','c','i','i','g','g','o','o','u','u','s','s','a','a'], $this->district_name);

		$targetLocation = "https://servis.mgm.gov.tr/api/merkezler?il=" . $province . '&ilce=' . $district; // İl ve İlçe bilgilerini getirir. ilçe yoksa veya yanlışsa mgm sitesindeki varsayılan ilçe için sonuçları getirir. Örn. Ankara için keçiören ilçesi
		$weatherNow = "https://servis.mgm.gov.tr/api/sondurumlar?merkezid="; // Hava durumunu getiren URL. merkezid değerini daha elde etmediğimiz için yazılmadı
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $targetLocation );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		if(strlen(curl_exec($curl)) == 2){
			return '{"code": "404","message": "Province or District is not valid"}'; //yanlis il ve ilce yazildiginda
		}
		$this->targetLocationDetails = json_decode(curl_exec($curl))[0];
		curl_setopt($curl, CURLOPT_URL, $weatherNow . $this->targetLocationDetails->merkezId ); // merkezid değeri burdan giriliyor
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$this->weatherDetails = json_decode(curl_exec($curl))[0];
		curl_close($curl);
	}

	public function getAll(){ // Tüm hava durumunu json formatında döndürüyor
		return json_encode($this->weatherDetails);
	}

	public function temperature(){ // sıcaklık değerini string olarak döndürüyor (birimi C)
		return $this->weatherDetails->sicaklik;
	}
	public function temperatureF(){ // sıcaklık değerini string olarak döndürüyor (birimi C)
		return (floatval($this->weatherDetails->sicaklik) * 9/5) + 32;
	}
	public function temperatureK(){ // sıcaklık değerini string olarak döndürüyor (birimi C)
		return floatval($this->weatherDetails->sicaklik) + 274.15;
	}

	public function pressure(){ // aktüel basınç değerini string olarak döndürüyor (birimi hPa)
		return $this->weatherDetails->aktuelBasinc;
	}

	public function seaPressure(){ // denize indirgenmiş basınç değerini string olarak döndürüyor (birimi hPa)
		return $this->weatherDetails->denizeIndirgenmisBasinc;
	}

	public function airHumidity(){ // nem değerini string olarak döndürüyor (yüzde olarak)
		return $this->weatherDetails->nem;
	}

	public function windSpeed(){ // rüzgar hızı değerini string olarak döndürüyor (birimi km/sa)
		return $this->weatherDetails->ruzgarHiz;
	}

	public function rainNow(){ // şu andaki yağış miktarının değerini string olarak döndürüyor (birimi mm)
		return $this->weatherDetails->yagis00Now;
	}

	public function rain10mins(){ // şu anı takip eden 10 dakika süresi için yağış miktarının değerini string olarak döndürüyor (birimi mm)
		return $this->weatherDetails->yagis10Dk;
	}

	public function rain12hours(){ // şu anı takip eden 12 saat süresi için yağış miktarının değerini string olarak döndürüyor (birimi mm)
		return $this->weatherDetails->yagis12Saat;
	}

	public function rain1hour(){ // şu anı takip eden 1 saat süresi için yağış miktarının değerini string olarak döndürüyor (birimi mm)
		return $this->weatherDetails->yagis12Saat;
	}

	public function rain24hours(){ // şu anı takip eden 24 saat süresi için yağış miktarının değerini string olarak döndürüyor (birimi mm)
		return $this->weatherDetails->yagis24Saat;
	}

	public function rain6hours(){ // şu anı takip eden 6 saat süresi için yağış miktarının değerini string olarak döndürüyor (birimi mm)
		return $this->weatherDetails->yagis24Saat;
	}

	public function event(){ // hava hadisesini json formatında döndürüyor. İçerik(hadise kodu - Türkçe Açıklaması - İngilizce Açıklaması)
		$codes = ['/\bA\b/','/\bAB\b/', '/\bDMN\b/', '/\bHY\b/','/\bHSY\b/', '/\bHKY\b/', '/\bMSY\b/', '/\bKKY\b/','/\bGKR\b/','/\bSCK\b/','/\bPB\b/','/\bPUS\b/','/\bY\b/','/\bSY\b/','/\bK\b/','/\bDY\b/','/\bR\b/','/\bKKR\b/','/\bSGK\b/','/\bCB\b/','/\bSIS\b/','/\bKY\b/','/\bKSY\b/','/\bYKY\b/','/\bGSY\b/','/\bKF\b/','/\bKGY\b/'];
		$turkish = ['Açık', 'Az Bulutlu', 'Duman', 'Hafif Yağmurlu','Hafif Sağanak Yağışlı', 'Hafif Kar Yağışlı', 'Yer Yer Sağanak Yağışlı', 'Karla Karışık Yağmurlu','Güneyli Kuvvetli Rüzgar','Sıcak','Parçalı Bulutlu','Pus','Yağmurlu','Sağanak Yağışlı','Kar Yağışlı','Dolu','Rüzgarlı','Kuzeyli Kuvvetli Rüzgar','Soğuk','Çok Bulutlu','Sis','Kuvvetli Yağmurlu','Kuvvetli Sağanak Yağışlı','Yoğun Kar Yağışlı','Gökgürültülü Sağanak Yağışlı','Toz veya Kum Fırtınası','Kuvvetli Gökgürültülü Sağanak Yağışlı'];
		$english = ['Clear', 'Intermittent Clouds', 'Smokey', 'Partly Rainy','Showers', 'Partly Snow Showers', 'Partly Showers', 'Rain and Snow','Strong Wind From South','Hot','Partly Cloudy','Haze','Rainy','Heavy Rain','Snow','Hail','Windy','Strong Wind From North','Cold','Mostly Cloudy','Fog','Strong Rainy','Strong Showers','Heavy Snow','Showers With T-Storms','Dust or Sand Storm','Strong T-Storms with Showers'];
		$response = [
			'code' => $this->weatherDetails->hadiseKodu,
			'turkish' => preg_replace($codes, $turkish, $this->weatherDetails->hadiseKodu),
			'english' => preg_replace($codes, $english, $this->weatherDetails->hadiseKodu)
		];
		return json_encode($response);
	}

	function province($p=null){ // p değeri boş ise daha önce girilmiş il adını string olarak döndürür. p değeri boş değilse yeni il adı tanımlar
		if($p != null){
			$this->province_name = $p;
			$this->getData();
		}else{
			return $this->targetLocationDetails->il;
		}
	}
	function district($d=null){ // d değeri boş ise daha önce girilmiş ilçe adını string olarak döndürür. d değeri boş değilse yeni ilçe adı tanımlar
		if($d != null){
			$this->district_name = $d;
			$this->getData();
		}else{
			return $this->targetLocationDetails->ilce;
		}
	}

	function longitude(){ // il ve ya ilçenin boylam değerini döndürür
		return $this->targetLocationDetails->boylam;
	}

	function latitude(){ // il ve ya ilçenin enlem değerini döndürür
		return $this->targetLocationDetails->enlem;
	}
	
}

?>