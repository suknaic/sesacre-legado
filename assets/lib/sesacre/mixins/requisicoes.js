axios.interceptors.request.use(function (config){
        $.LoadingOverlay("show");
        return config;
    }, function (erro) {
       return Promise.reject(erro); 
    });
axios.interceptors.response.use(function (response){
        $.LoadingOverlay("hide");
        return response;
    }, function (erro){
       return Promise.reject(erro); 
    });
    

function Requisicoes(){
    
    this.axiosPost = function(url,dados,callback){
        var data = $.param(dados); //Função do Jquery que converte JSON em QueryString
        axios({
            url: url,
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            data: data
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


