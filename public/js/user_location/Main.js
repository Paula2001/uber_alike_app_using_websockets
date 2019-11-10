class Main{
    static actions(){
        $(document).ready(function(){
            $('#location').keyup(function(){
                
                Main.sendAjaxReq($(this).val());
            });    
        });        
    }
    static sendAjaxReq(search){
        if(search === ' ' || search === ''){
            search = '%20'
            $('#search_holders').css('display','none');
        }
        
        $.ajax({
            url : `${base_url}/home/location/${search}`,
            method : "GET",
            success : function(response){
                Main.createResults(response);

            },
            error : function(){
                alert('error');
            }
        });
    }
    static createResults(jsonObj){
        $('#search_holders').html('');
        let object = JSON.parse(jsonObj);
        for (const key in object['features']){
            $('#search_holders').css('display','block');
            let long_number = object['features'][key]['geometry'].coordinates[0];
            let lat_number = object['features'][key]['geometry'].coordinates[1];
            let para = document.createElement('h3');
            let lat = document.createElement('p');
            lat.className = 'lat'; 
            let row = document.createElement('div');
            row.className = 'row';
            let long = document.createElement('p');
            long.className = 'long';
            long.setAttribute('data-long',long_number); 
            lat.setAttribute('data-lat',lat_number); 
            $(lat).text(`Latitude = ${lat_number}`);
            $(long).text(`Longitude ${long_number} ,`);
            $(para).text(object['features'][key]['properties'].name);
            $(row).append(long);
            $(row).append(lat);
            $('#search_holders').append(para);
            $('#search_holders').append(row);

        }
    }
}
Main.actions();
