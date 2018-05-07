var map;
 
function initialize() {
    //var latlng = new google.maps.LatLng(-18.8800397, -47.05878999999999);
    //var latlng = new google.maps.LatLng(-9.9696794, -67.8131228);
    var latlng = new google.maps.LatLng(-9.116209, -72.5522151);
 
    var options = {
        zoom: 6,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
 
    map = new google.maps.Map(document.getElementById("mapa"), options); 
   
}
 
initialize();


function carregarPontos() {
 
    $.getJSON('pontos.json', function(pontos) {
 
        $.each(pontos, function(index, ponto) {
            var contentString = "<div><h2 class=\"infoBox\">"+ponto.Descricao+"</h2><p>"+ponto.Descricao+"</p></div>";
            
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(ponto.Latitude, ponto.Longitude),
                title: ponto.Descricao,
                map: map
            });
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
            
            
            
        });
        
 
    });
 
}
 
carregarPontos();

