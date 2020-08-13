document.querySelector('.bt-location').addEventListener('click', () => {
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(setLocation);
    }else{
        console.log('erro');
    }
});

function setLocation(pos){
    const lat = pos.coords.latitude;
    const lng = pos.coords.longitude;
    
    const inputLat = document.querySelector('input[name="lat"]');
    const inputLng = document.querySelector('input[name="lng"]');
          inputLat.setAttribute('value', lat);
          inputLng.setAttribute('value', lng);
        
    const alertGeolocation = document.querySelector('.alertGeolocation');
          alertGeolocation.style.display = 'block';
          alertGeolocation.classList.add('animated', 'fadeIn');
}


