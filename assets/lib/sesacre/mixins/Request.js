
var request = {
    methods: {
        post: function(url,dados){
            
            axios({
              url: url,
              method: 'POST',
              headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                  'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
              },
              data: dados
            }).then(function(response)/* OU response => (deste modo o escopo continua sendo a instancia do Vue Model(vm))*/{            
                console.log(response);
            });
        }
    }
}


