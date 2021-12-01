<!DOCTYPE html>
<html>
<head>
	<meta name="format-detection" content="telephone=no"> <meta name="msapplication-tap-highlight" content="no">
	<meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover"> <meta name="color-scheme" content="light dark"> 
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css"> 
	<link rel="stylesheet" href="css/estilo.css">
	<script src="bootstrap/js/bootstrap.js"></script>
	<script>
		function confirmDelete(delUrl) {
  			if (confirm("Deseja apagar o registro?")) {
   				document.location = delUrl;
	        }  
		}

		function lerNome(){
			var name = document.getElementById("txtNome").value;				
			return name;
		}
		function lerTel(){
			var tel = document.getElementById("txtTelefone").value;				
			return tel;
		}
		function lerOri(){
			var ori = document.getElementById("txtOrigem").value;				
			return ori;
		}
		function lerDat(){
			var dat = document.getElementById("txtDataContato").value;				
			return dat;
		}
		function lerObs(){
			var obs = document.getElementById("txtObservacao").value;				
			return obs;
		}

		function editar(valor, valorAtual1, valorAtual2, valorAtual3){
			var db = firebase.firestore();
    		var ag = db.collection("agendamentos").where("nome", "==", valor);

	        ag.get()
	        .then((querySnapshot) => {
	            querySnapshot.forEach((doc) => {
	                var dados = db.collection("agendamentos").doc(doc.id);

	                dados.update({
	                    nome: valorAtual1,
	                    endereco: valorAtual2,
	                    bairro: valorAtual3
	                })
	                .then(() => {
	                    console.log("Document successfully updated!");
	                })
	                .catch((error) => {
	                    // The document probably doesn't exist.
	                    console.error("Error updating document: ", error);
	                });
	            });
	        })
	        .catch((error) => {
	            console.log("Error getting documents: ", error);
	        });
		}

		function listar(valor){
			var db = firebase.firestore();

			db.collection("agendamentos").where("nome", "==", valor)
				.get()
				.then((querySnapshot) => {
    				querySnapshot.forEach((doc) => {
        				// doc.data() is never undefined for query doc snapshots
        				console.log(doc.id, " => ", doc.data());

        				$('#resultado').append(doc.id + ' - ' + doc.data().nome + '<br>');
    				});
				})
				.catch((error) => {
    				console.log("Error getting documents: ", error);
				});

		}

		function excluir(valor){
			var db = firebase.firestore();

			db.collection("agendamentos").where("nome", "==", valor)
				.get()
				.then((querySnapshot) => {
    				querySnapshot.forEach((doc) => {
        				db.collection("agendamentos").doc(doc.id).delete().then(() => {
							console.log("Document successfully deleted!");
						}).catch((error) => {
						    console.error("Error removing document: ", error);
						});
    				});
				})
				.catch((error) => {
    				console.log("Error getting documents: ", error);
				});
		}
	</script>
	<title>SISTEMA DE AGENDAMENTO - CLIENTES</title>
</head> 
<body> 
	<div class="container">
		<div class="row">
			<nav class="navbar navbar-expand-lg navbar-dark bg-primary col-12">
				<a class="navbar-brand" href="#">SISTEMA WEB</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavDropdown">
					<ul class="navbar-nav">
						<li class="nav-item active">
							<a class="nav-link" href="index.php">Cadastrar<span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="consultarClientes.php">Consultar</a>
						</li>
					</ul>
				</div>
			</nav>  
		</div>
		<div class="row">
			<div class="card mb-3 col-12">
				<div class="card-body" style="margin: auto;">
					<h5 class="card-title">Consultar - Contatos Agendados</h5>
					<table class="table table-responsive" style="width: auto;">
						<thead class="table-active bg-primary">
							<tr>
								<th scope="col">Nome</th>
								<th scope="col">Telefone</th>
								<th scope="col">Origem</th>
								<th scope="col">Contato</th>
								<th scope="col">Observação</th>
								<th scope="col">Ação</th>
							</tr>
						</thead>
						<tbody id="TableData">
						<?php
							$controller = new ControllerCadastro();
							$resultado = $controller->listar(0);
							for($i=0;$i<count($resultado);$i++){ 
						?>
								<tr>
									<td scope="col"><?php echo $resultado[$i]['nome']; ?></td>
									<td scope="col"><?php echo $resultado[$i]['telefone']; ?></td>
									<td scope="col"><?php echo $resultado[$i]['origem']; ?></td>
									<td scope="col"><?php echo $resultado[$i]['data_contato']; ?></td>
									<td scope="col"><?php echo $resultado[$i]['observacao']; ?></td>
									<td scope="col">
										<button type="button" class="btn btn-outline-primary" onclick="location.href='editarClientes.php?id=<?php echo $resultado[$i]['id']; ?>'" style="width: 70px;">Editar</button>
										<button type="button" class="btn btn-outline-primary" onclick="javascript:confirmDelete('excluirClientes.php?id=<?php echo $resultado[$i]['id']; ?>')" style="width: 74px;">Excluir</button>
									</td>
								</tr>
						<?php
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
