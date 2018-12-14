
function Requisicoes(){
    
    this.axiosPost = function(url,dados,callback){
        axios({
            url: url,
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            data: dados
            }).then(function(response) /* OU response => (deste modo o escopo continua sendo a instancia do Vue Model(vm))*/{     
                callback(response.data);
            }).catch (function(erro){
                console.log(erro);
                callback(erro);
            });
    }
    
    this.axiosGet = function(url,params,callback){
        axios({
            url: url,
            method: 'GET',
            params: params
        }).then(function(response){ 
            callback(response.data);
        }).catch(function(erro){
            console.log(erro);
            callback(erro);
        }); 
    }
}


