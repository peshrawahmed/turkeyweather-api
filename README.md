# turkeyweather-api
Türkiye il ve ilçeleri güncel hava durumlarını Meteoroloji Genel Müdürlüğü Sitesinden getirir. 2018

> **Çok Önemli:** Bu kütüphane `Meteoroloji Genel Müdürlüğü` tarafından getirilen kısıtlama nedeniyle terkedilmiştir. Lütfen alternatif bir kütüphane kullanın. Kullanıp beğendiğiniz bir kütüphane iletirseniz burada linkini paylaşabilirim.

## Kullanım
Kullanmadan Önce turkeyweather.php dosyasını projenize eklemeniz gerekebilir. Basit bir ekleme örneği
```php 
<?php
  include('turkeyweather.php');
?>
```
daha sonra aşağıdaki örnekler gibi yeni nesne oluşturarak kullanabilirsiniz.
```php 
<?php
  $weather = new TurkeyWeather('ankara','altındağ'); 
?>
```
veya
```php 
<?php
  $weather = new TurkeyWeather(); 
  $weather->province('istanbul');
  $weather->district('fatih');
?>
```
İl değerini belirtmek kütüphanenin çalışması için zorunludur. İlçe zorunlu değil. Belirtilmediği zaman MGM'nin her il için belirlediği 'varsayılan' ilçesi için sonuçlar döndürülür. Örnek İstanbul için Bakırköy ilçesi seçilmiş
<br />
En sonunda almak istediğimiz verinin metodunu çağırarak o veriyi elde edebileceğiz. Örnek:
```php 
<?php
  echo 'Sıcaklık ' . $weather->Temperature() . ' derecedir';
?>
```
###### Çıktı:
> Sıcaklık 13.5 derecedir.

## Metodlar ve Çıktıları
#### 1. province($p)
İki şekilde çalışır.
1. p değeri belirtilmişse. İl değerini değiştirir. Örnek:
```php 
<?php
  echo $weather->province('hatay');
?>
```
###### Çıktı:
> 
2. p değeri belirtilmemişse. İl değerini döndürür. Örnek:
```php 
<?php
  echo $weather->province();
?>
```
###### Çıktı:
> Samsun

#### 2. district($d)
İki şekilde çalışır.
1. d değeri belirtilmişse. İlçe değerini değiştirir. Örnek:
```php 
<?php
  echo $weather->province('etimesgut');
?>
```
###### Çıktı:
> 
2. d değeri belirtilmemişse. İlçe değerini döndürür. Örnek:
```php 
<?php
  echo $weather->province();
?>
```
###### Çıktı:
> Konyaaltı

#### 3. GetAll()
MGM'den aldığı tüm verileri JSON formatında döndürür. Örnek:
```php 
<?php
  echo $weather->getAll();
?>
```
###### Çıktı:
```json
{
  "aktuelBasinc":912,
  "denizSicaklik":-9999,
  "denizeIndirgenmisBasinc":1023.3,
  "gorus":20000,
  "hadiseKodu":"PB",
  "istNo":17238,
  "kapalilik":4,
  "karYukseklik":-9999,
  "nem":44,
  "rasatMetar":"-9999",
  "rasatSinoptik":"-9999",
  "rasatTaf":"-9999",
  "ruzgarHiz":3.6,
  "ruzgarYon":188,
  "sicaklik":12.2,
  "veriZamani":"2018-02-07T13:27:00.000Z",
  "yagis00Now":0.2,
  "yagis10Dk":0,
  "yagis12Saat":0.2,
  "yagis1Saat":0,
  "yagis24Saat":0.2,
  "yagis6Saat":0.2,
  "denizVeriZamani":"2018-02-07T06:00:00.000Z"
}
```



#### 4. temperature()
Sıcaklık değerini döndürür. birimi Santigrattir. Örnek:
```php 
<?php
  echo $weather->temperature();
?>
```
###### Çıktı:
> 12.3

#### 5. temperatureK()
Sıcaklık değerini Kelvin Birimiyle döndürür. Örnek:
```php 
<?php
  echo $weather->temperatureK();
?>
```
###### Çıktı:
> 56.12

#### 6. temperatureF()
Sıcaklık değerini Fahrenheit birimiyle döndürür. Örnek:
```php 
<?php
  echo $weather->temperatureF();
?>
```
###### Çıktı:
> 56.12


#### 7. pressure()
Aktüel Basınç değerini döndürür. birimi Hektopaskaldir(hPa). Örnek:
```php 
<?php
  echo $weather->pressure();
?>
```
###### Çıktı:
> 912


#### 8. seaPressure()
Denize İndirgenmiş Basınç değerini döndürür. birimi Hektopaskaldir(hPa). Örnek:
```php 
<?php
  echo $weather->pressure();
?>
```
###### Çıktı:
> 1023.3

#### 9. airHumidity()
Nem oranını yüzde olarak döndürür. Örnek:
```php 
<?php
  echo $weather->airHumidity();
?>
```
###### Çıktı:
> 45

#### 10. windSpeed()
Rüzgar hızını döndürür. birimi km/sa. Örnek:
```php 
<?php
  echo $weather->windSpeed();
?>
```
###### Çıktı:
> 3.21

#### 11. rainNow() 12. rain10mins() 13. rain1hour() 14. rain6hours() 15. rain12hours() 16. rain24hours()
Metod başlığında belirtilen zaman dilimindeki yağış miktarını döndürür. birimi mm. Örnek:
```php 
<?php
  echo $weather->rainNow();
?>
```
###### Çıktı:
> 0

#### 17. event()
Hava hadisesini json formatında döndürür. 
```json
{
  "code" : "XXX",
  "turkish" : "XXXXX",
  "english" : "XXXXXXX"
}
```
Örnek:
```php 
<?php
  echo $weather->event();
?>
```
###### Çıktı:
> {"code":"CB","turkish":"Çok Bulutlu","english":"Mostly Cloudy"}

#### 18. longitude()
İl ve ya ilçenin boylam derecesini döndürür. Örnek:
```php 
<?php
  echo $weather->longitude();
?>
```
###### Çıktı:
> 30.294

#### 19. latitude()
İl ve ya ilçenin enlem derecesini döndürür. Örnek:
```php 
<?php
  echo $weather->latitude();
?>
```
###### 37.722:
> 30.294

[peshraw@live.com](mailto:peshraw@live.com)

## License: MIT License
Copyright 2018 PESHRAW AHMED

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
