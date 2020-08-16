@extends('contacts.layout')
@section('content')
<div class="row">
<div class="col-lg-12" style="text-align: center">
  <div >
    <h2>Cadastro de Usuários</h2>
  </div>
  <br/>
</div>
</div>

<div class="row">
<div class="col-lg-12 margin-tb">
  <div class="pull-right">
  <a href="javascript:void(0)" class="btn btn-success mb-2" id="new-contact" data-toggle="modal">Novo Usuário</a>
  </div>
</div>
</div>
  <br/>
  @if(session()->get('success'))
    <div class="alert alert-success">
    {{ session()->get('success') }}  
    </div>
  @endif
  @if(session()->get('error'))
    <div class="alert alert-danger">
    {{ session()->get('error') }}  
    </div>
  @endif
  <table class="table table-bordered">
    <tr>
      <td>ID</td>
      <td>Nome</td>
      <td>CPF</td>
      <td>Idade</td>
      <td>Whatsapp</td>
      <th width="280px">Ações</th>
    </tr>

    @foreach($contacts as $contact)
      <tr id="contact_id_{{ $contact->id }}">
        <td>{{$contact->id}}</td>
        <td>{{$contact->name}}</td>
        <td>{{$contact->cpf}}</td>
        <td>{{$contact->age}}</td>
        <td>{{$contact->whatsapp}}</td>
        <td>
          <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST">
            <a href="javascript:void(0)" class="btn btn-info" id="covid-contact" data-toggle="modal" data-id="{{ $contact->id }}">Formulário de Consulta</a>
            <a href="javascript:void(0)" class="btn btn-success" id="edit-contact" data-toggle="modal" data-id="{{ $contact->id }}">Editar </a>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Deletar</button>
          </form>
        </td>
      </tr>
    @endforeach
</table>

  <!-- Modal Adicionar/Editar Usuário -->
  <div class="modal fade" id="crud-modal" aria-hidden="true" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="contactCrudModal"></h4>
        </div>
        <div class="modal-body">
          <form name="contactForm" action="{{ route('contacts.store') }}" method="POST">
            <input type="hidden" name="contact_id" id="contact_id" >
            @csrf
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <strong>Nome:</strong>
                <input type="text" name="name" id="name" class="form-control" placeholder="Nome" onchange="validate()" required>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <strong>CPF:</strong>
                <input type="text" name="cpf" id="cpf" class="form-control" maxlength="14" placeholder="CPF" onkeypress="cpfMask(this)" onchange="validate()" onblur="cpfValidate(this)" required>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <strong>Idade:</strong>
                <input type="number" name="age" id="age" class="form-control" maxlength="3" placeholder="Idade" onchange="validate()" onkeypress="validate()" required>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <strong>Whatsapp:</strong>
                <input type="text" name="whatsapp" id="whatsapp" class="form-control" maxlength="15" placeholder="Whatsapp" onchange="validate()" onkeypress="whatsappMask(this)" required> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <strong>Upload 3x4:</strong>
                <input type="file" name="image" id="image" class="form-control" required>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Salvar</button>
                <a href="{{ route('contacts.index') }}" class="btn btn-danger">Cancelar</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Formulário de Consulta - COVID-19 -->
<div class="modal fade" id="crud-modal-form" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="contactCrudModal-form"></h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="contact_id" id="contact_id" >
        <div class="row">
          <div class="col-xs-2 col-sm-2 col-md-2"></div>
          <div class="col-xs-10 col-sm-10 col-md-10 ">
            @if(isset($contact->id))
              <fieldset>
                <table>
                  <tr>
                    <td><strong>Nome:</strong></td>
                    <td>{{$contact->name}}</td>
                  </tr>
                  <tr>
                    <td><strong>CPF:</strong></td>
                    <td>{{$contact->cpf}}</td>
                  </tr>
                  <tr>
                    <td><strong>Idade:</strong></td>
                    <td>{{$contact->age}}</td>
                  </tr>
                  <tr>
                    <td><strong>Whatsapp:</strong></td>
                    <td>{{$contact->whatsapp}}</td>
                  </tr>
                </table>
              </fieldset>

              <fieldset>
                <table>
                  <tr>
                    <td><strong>Febre:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="febre" ></td>
                  </tr>
                  <tr>
                    <td><strong>Coriza:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="coriza" ></td>
                  </tr>
                  <tr>
                    <td><strong>Nariz Entupido:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="narizEntupido" ></td>
                  </tr>
                  <tr>
                    <td><strong>Cansaço:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="cansaco" ></td>
                  </tr>
                  <tr>
                    <td><strong>Tosse:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="tosse" ></td>
                  </tr>
                  <tr>
                    <td><strong>Dor de Cabeça:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="dorCabeca" ></td>
                  </tr>
                  <tr>
                    <td><strong>Dores no Corpo:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="dorCorpo" ></td>
                  </tr>
                  <tr>
                    <td><strong>Mal Estar Geral:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="malEstar" ></td>
                  </tr>
                  <tr>
                    <td><strong>Dor de Garganta:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="dorGarganta" ></td>
                  </tr>
                  <tr>
                    <td><strong>Dificuldade de respirar:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="dificuldadeRespirar" ></td>
                  </tr>
                  <tr>
                    <td><strong>Falta de Paladar:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="faltaPaladar" ></td>
                  </tr>
                  <tr>
                    <td><strong>Falta de Olfato:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="faltaOlfato" ></td>
                  </tr>
                  <tr>
                    <td><strong>Dificuldade de Locomoção:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="dificuldadeLocomocao" ></td>
                  </tr>
                  <tr>
                    <td><strong>Diarréia:</strong></td>
                    <td><input type="checkbox" name="sintoma[]" id="diarreia" ></td>
                  </tr>
                </table>
              </fieldset>
              <div class="col-xs-10 col-sm-10 col-md-10 text-center">
                <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" onclick="calculate()">Calcular</button>
                <a href="{{ route('contacts.index') }}" class="btn btn-danger">Voltar</a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

<script type="text/javascript">
error=false

//Valida se campos foram preenchidos.
function validate(){
	if(document.contactForm.name.value !='' && document.contactForm.cpf.value !='' && document.contactForm.age.value > 0 && document.contactForm.age.value <= 120 && document.contactForm.whatsapp.value !='' && document.contactForm.image.files.length !=0 )
    document.contactForm.btnsave.disabled=false
	else
		document.contactForm.btnsave.disabled=true
}

//Calcula porcentagem de suspeita de Covid-19.
function calculate() {
  var percentage = 0;
  var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');
  var checkboxesTot = document.querySelectorAll('input[type=checkbox]');

  if (checkboxes.length === 0)
    percentage = 0;
  else
    percentage = (checkboxes.length * (100 / checkboxesTot.length)).toFixed(0);

  if (percentage >= 60) {
    alert('POSSÍVEL INFECTADO ' + percentage + '%');
  } else {
    if (percentage < 60 && percentage >= 40) {
      alert('POTENCIAL INFECTADO ' + percentage + '%');
    } else {
      alert('SINTOMAS INSUFICIENTES ' + percentage + '%');
    }
  }
}

//Máscaras e validação de https://gist.github.com/ricardodantas/6031749
//Máscara Whatsapp.
function whatsappMask(whatsapp){  
  if(mascaraInteiro(whatsapp)==false){
    event.returnValue = false;
  }       
  return formataCampo(whatsapp, '(00) 00000-0000', event);
}

//Máscara CPF.
function cpfMask(cpf){
  if(mascaraInteiro(cpf)==false){
    event.returnValue = false;
  }       
  return formataCampo(cpf, '000.000.000-00', event);
}

//valida o CPF digitado
function cpfValidate(cpf){
  var cpf = cpf.value;
  exp = /\.|\-/g
  cpf = cpf.toString().replace( exp, "" );
  var digit = eval(cpf.charAt(9)+cpf.charAt(10));
  var sum1 = 0, sum2 = 0;
  var vlr = 11;

  for(i = 0; i < 9; i++){
    sum1 += eval(cpf.charAt(i) * (vlr-1));
    sum2 += eval(cpf.charAt(i) * vlr);
    vlr--;
  }       
  sum1 = (((sum1*10) % 11) == 10 ? 0 : ((sum1*10) % 11));
  sum2 = (((sum2+(2*sum1)) * 10) % 11);

  var result = (sum1 * 10) + sum2;
  if(result != digit || cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")
    alert('CPF Invalido!');
}

//Valida número com máscara
function mascaraInteiro(){
  if (event.keyCode < 48 || event.keyCode > 57){
    event.returnValue = false;
    return false;
  }
  return true;
}

//Formata genericamente
function formataCampo(campo, Mascara, evento) { 
  var booleanMask; 

  var digit = evento.keyCode;
  exp = /\-|\.|\/|\(|\)| /g
  onlyNumbers = campo.value.toString().replace( exp, "" ); 

  var position = 0;    
  var newValue="";
  var maskLength = onlyNumbers.length;; 

  if (digit != 8) {
    for(i=0; i<= maskLength; i++) { 
      booleanMask  = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".") || (Mascara.charAt(i) == "/")) 
      booleanMask  = booleanMask || ((Mascara.charAt(i) == "(")  || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " ")) 
      if (booleanMask) { 
        newValue += Mascara.charAt(i); 
        maskLength++;
      } else {
        newValue += onlyNumbers.charAt(position);
        position++;
      }              
    }      
    campo.value = newValue;
    return true; 
  } else { 
    return true; 
  }
}
</script>