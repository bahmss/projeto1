<!DOCTYPE html>

<html>
<head>
    <title>Cadastro de Usuários</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
    @yield('content')
    </div>
</body>

<script>

$(document).ready(function () {

    /* Adicionar */
    $('#new-contact').click(function () {
        $('#btn-save').val("create-contact");
        $('#contact').trigger("reset");
        $('#contactCrudModal').html("Adicionar");
        $('#crud-modal').modal('show');
    });

    /* Editar */
    $('body').on('click', '#edit-contact', function () {
        var contact_id = $(this).data('id');
        $.get('contacts/'+contact_id+'/edit', function (data) {
            $('#contactCrudModal').html("Editar");
            $('#btn-update').val("Update");
            $('#btn-save').prop('disabled',false);
            $('#crud-modal').modal('show');
            $('#contact_id').val(data.id);
            $('#name').val(data.name);
            $('#cpf').val(data.cpf);
            $('#age').val(data.age);
            $('#whatsapp').val(data.whatsapp);
        })
    });

    /* Formulário de Consulta */
    $('body').on('click', '#covid-contact', function () {
        var contact_id = $(this).data('id');
        $.get('contacts/'+contact_id+'/show', function (data) {
            $('#contactCrudModal-form').html("Formulário de Consulta");
            $('#crud-modal-form').modal('show');
        })
    });

});

</script>
</html>