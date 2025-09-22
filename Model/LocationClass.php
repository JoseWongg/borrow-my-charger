<?php
//a script which can be then injected into an object in the controller and included in a view code
class LocationClass
{
    // Method to get the user's location
    public function getLocationCode()
    {
        $code = <<<EOT
<script>
function getLocation() 
{
    if (navigator.geolocation) 
    {
      navigator.geolocation.getCurrentPosition(showPosition, onError);
    } else 
    {
      console.log("Geolocation not supported.");
      alert("Geolocation is not supported by this browser.");
    }
  }
//Shows alert to user when geolocation information is obtained
  function showPosition(position) 
  {  
        localStorage.setItem('latitude', position.coords.latitude.toString());
        localStorage.setItem('longitude', position.coords.longitude.toString());
        console.log("Latitude: " + position.coords.latitude + ", Longitude: " + position.coords.longitude);
    
    //localStorage is used to cause the alert showing only on the first page load
    if (!localStorage.getItem('locationAlertShown')) 
    {
           alert("We have access to your location.");
           localStorage.setItem('locationAlertShown', true);
    }
  }
  
 // If we don't have permission or there was an error, display a message to the user
  function onError()
  {    
                switch(error.code)
                {
                    case error.PERMISSION_DENIED:
                        alert("You denied permission to access your location.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        alert("The request to get your location timed out.");
                        break;
                    default:
                        alert("An unknown error occurred.");
                        break;
                }
  }
  
  getLocation();

</script>

EOT;
        return $code;
    }
}
