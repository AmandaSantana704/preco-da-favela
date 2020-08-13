    document.querySelector('#getUserLocation').addEventListener('click', () => {
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(setLocation);
        }else{
            console.log('erro');
        }
    });
 
    function setLocation(pos){
        const lat = pos.coords.latitude;
        const lng = pos.coords.longitude;
        console.log(pos);
        
        $.ajax({
            method: 'GET',
            url: '/localizacao-usuario',
            data: {lat:lat, lng:lng},
            success:function(response){
                sessionStorage.setItem('usergeolocation', response);
                window.location.href = window.location.href;
                console.log(response);
            },
            error:function(error){
                console.log(error);
            }

        });
    }
    
    if(sessionStorage.getItem('usergeolocation') != null){
        let location = sessionStorage.getItem('usergeolocation');
        let splitLocation = location.split('/');
        const lat = splitLocation[0];
        const lng = splitLocation[1];
        if(sessionStorage.getItem('adressUser') == null){
            const apiKey = 'APIKeY';
            const geocordinationAPI = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${apiKey}`;
            let adressUser =  document.querySelector('#adressUser');
            $.ajax({
                url: geocordinationAPI,
                method: 'GET',
                success:function(response){
                    sessionStorage.setItem('adressUser', response.results[1].formatted_address);
                    adressUser.innerHTML = response.results[1].formatted_address;
                    console.log(response.results[1].formatted_address);
                },
                error:function(){
                    console.log('error');
                }
            });
        }else{
            adressUser.innerHTML = sessionStorage.getItem('adressUser');
            console.log('not request');
        }
    }else{
        console.log('not exist');
    }
