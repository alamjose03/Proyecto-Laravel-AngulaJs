app.controller('clientesController', function ($scope, $http, API_URL) {

    $http({
        method: 'GET',
        url: API_URL +"clientes"
    }). then(function(response){
        $scope.clientes= response.data.clientes;
        console.log(response);
    },function(error){
        console.log(error);
        alert('Se ha producido un error');
    });

    $scope.toggle = function(modalstate, id){
        $scope.modalstate= modalstate;
        $scope.cliente = null;

        switch(modalstate){
            case 'add':
                $scope.form_title = "Agregar nuevo cliente";
                break;
            case 'edit':
                $scope.form_title= "Detalles del cliente";
                $scope.id =id;
                $http.get(API_URL + 'clientes/' + id)
                    .then(function(response){
                        console.log(response);
                        $scope.cliente= response.data.cliente;
                    });
                break;
            default:
                break;
        }

        console.log(id);
        $('#myModal').modal('show');
    }

    $scope.save = function (modalstate, id){
        var url = API_URL + "clientes";
        var method = "POST";

        if(modalstate === 'edit'){
            url += "/" + id;

            method = "PUT";
        }

        $http({
            method: method,
            url: url,
            data: $.param($scope.cliente),
            headers:{ 'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response){
            console.log(response);
            location.reload();
        }), (function(error){
            console.log(error);
            alert('Se ha producido un error');
        });
    }

    $scope.confirmDelete = function (id){
        var isConfirmDelete = confirm('¿Está seguro de eliminar este registro?');
        if(isConfirmDelete){

            $http({
                method: 'DELETE',
                url: API_URL + 'clientes/' + id
            }).then(function(response){
                console.log(response);
                location.reload();
            }, function(error){
                console.log(error);
                alert('No se puede eliminar este registro');
            });
        }
        else{
            return false;
        }
    }
});